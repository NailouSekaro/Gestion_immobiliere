<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Mail\NewMessageNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    public function index()
    {
        $messages = auth()->user()->receivedMessages()
            ->with(['expediteur' => function($query) {
                $query->withTrashed();
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('messages.index', compact('messages'));
    }

    public function create()
    {
        $users = User::where('id', '!=', auth()->id())
            ->where('est_actif', true)
            ->get(['id', 'nom', 'prenom', 'email', 'role']);

        return view('messages.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'destinataire_id' => 'required|exists:users,id',
            'sujet' => 'nullable|string|max:255',
            'contenu' => 'required|string|min:1|max:5000',
            'piece_jointe' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt'
        ]);

        // Vérifier que le destinataire est différent de l'expéditeur
        if ($request->destinataire_id == auth()->id()) {
            return back()->withErrors(['destinataire_id' => 'Vous ne pouvez pas vous envoyer un message à vous-même.']);
        }

        $messageData = [
            'expediteur_id' => auth()->id(),
            'destinataire_id' => $request->destinataire_id,
            'sujet' => $request->sujet,
            'contenu' => $request->contenu
        ];

        // Gestion de la pièce jointe
        if ($request->hasFile('piece_jointe')) {
            $file = $request->file('piece_jointe');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->store('messages/pieces-jointes', 'public');
            $messageData['piece_jointe'] = $path;
        }

        if ($request->has('reply_to_id')) {
            $messageData['reply_to_id'] = $request->input('reply_to_id');
        }

        $message = Message::create($messageData);

        // Envoyer une notification par email
        try {
            $destinataire = User::find($request->destinataire_id);
            Mail::to($destinataire->email)->send(new NewMessageNotification($message));
        } catch (\Exception $e) {
            \Log::error('Erreur envoi notification message: ' . $e->getMessage());
        }

        return redirect()->route('messages.sent')
            ->with('success', 'Message envoyé avec succès.');
    }

    public function show(Message $message)
    {
        // Vérifier que l'utilisateur peut voir ce message
        if (!$message->peutVoir(auth()->id())) {
            abort(403);
        }

        // Marquer comme lu si c'est le destinataire
        if ($message->destinataire_id === auth()->id() && !$message->lu) {
            $message->marquerCommeLu();
        }

        return view('messages.show', compact('message'));
    }

    // public function reply(Message $message)
    // {
    //     if (!$message->peutVoir(auth()->id())) {
    //         abort(403);
    //     }

    //     $sujet = "Re: " . ($message->sujet ?: 'Sans sujet');
    //     $users = User::where('id', '!=', auth()->id())->where('est_actif', true)->get();

    //     return view('messages.create', compact('replyTo', 'sujet', 'users'));
    // }



        public function reply(Message $message)
    {
        if (!$message->peutVoir(auth()->id())) {
            abort(403);
        }

        $sujet = "Re: " . ($message->sujet ?: 'Sans sujet');
        $users = User::where('id', '!=', auth()->id())
                    ->where('est_actif', true)
                    ->get();

        // Ici, on prépare la variable replyTo
        $replyTo = $message->expediteur;

        return view('messages.create', compact('replyTo', 'sujet', 'users','message'));
    }


    public function markAsRead(Message $message)
    {
        if ($message->destinataire_id === auth()->id()) {
            $message->marquerCommeLu();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 403);
    }

    public function markAsUnread(Message $message)
    {
        if ($message->destinataire_id === auth()->id()) {
            $message->update(['lu' => false, 'lu_le' => null]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 403);
    }

    public function destroy(Message $message)
    {
        if (!$message->peutVoir(auth()->id())) {
            abort(403);
        }

        // Supprimer la pièce jointe si elle existe
        if ($message->piece_jointe) {
            Storage::disk('public')->delete($message->piece_jointe);
        }

        $message->delete();

        return redirect()->route('messages.index')
            ->with('success', 'Message supprimé avec succès.');
    }

    public function sent()
    {
        $messages = auth()->user()->sentMessages()
            ->with(['destinataire' => function($query) {
                $query->withTrashed();
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('messages.sent', compact('messages'));
    }

    public function unread()
    {
        $messages = auth()->user()->unreadMessages()
            ->with('expediteur')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('messages.unread', compact('messages'));
    }

    // API methods
    public function unreadCount()
    {
        $count = auth()->user()->unreadMessages()->count();
        return response()->json(['count' => $count]);
    }

    public function latestMessages()
    {
        $messages = auth()->user()->receivedMessages()
            ->with('expediteur')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return response()->json($messages);
    }

    // Dans MessageController.php
    public function export()
    {
        $messages = auth()->user()->receivedMessages()
            ->with('expediteur')
            ->orderBy('created_at', 'desc')
            ->get();

        $csv = "Date,Expéditeur,Sujet,Message\n";

        foreach ($messages as $message) {
            $csv .= '"' . $message->created_at->format('d/m/Y H:i') . '",';
            $csv .= '"' . $message->expediteur->prenom . ' ' . $message->expediteur->nom . '",';
            $csv .= '"' . ($message->sujet ?? 'Sans sujet') . '",';
            $csv .= '"' . str_replace('"', '""', $message->contenu) . '"';
            $csv .= "\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="messages-export.csv"');
    }

    // Dans MessageController.php
public function search(Request $request)
{
    $query = $request->get('q');

    $messages = auth()->user()->receivedMessages()
        ->where(function($q) use ($query) {
            $q->where('contenu', 'like', "%{$query}%")
              ->orWhere('sujet', 'like', "%{$query}%")
              ->orWhereHas('expediteur', function($q) use ($query) {
                  $q->where('prenom', 'like', "%{$query}%")
                    ->orWhere('nom', 'like', "%{$query}%");
              });
        })
        ->with('expediteur')
        ->orderBy('created_at', 'desc')
        ->paginate(20);

    return view('messages.index', compact('messages', 'query'));
}
}
