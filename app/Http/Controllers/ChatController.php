<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    // Afficher la liste des conversations
    public function index()
    {
        $conversations = Message::getUserConversations(auth()->id());

        // Récupérer tous les utilisateurs pour le modal de nouvelle conversation
        $users = User::where('id', '!=', auth()->id())
            ->where('est_actif', true)
            ->orderBy('prenom')
            ->get();

        return view('chat.index', compact('conversations', 'users'));
    }

    // Afficher une conversation spécifique
    public function show($conversationId)
    {
        // Vérifier que l'utilisateur fait partie de cette conversation
        $firstMessage = Message::where('conversation_id', $conversationId)->first();

        if (!$firstMessage || !$firstMessage->peutVoir(auth()->id())) {
            abort(403, 'Accès non autorisé à cette conversation');
        }

        // Récupérer tous les messages de la conversation
        $messages = Message::conversation($conversationId)
            ->with(['expediteur', 'destinataire'])
            ->get();

        // Marquer tous les messages reçus comme lus
        Message::where('conversation_id', $conversationId)
            ->where('destinataire_id', auth()->id())
            ->where('lu', false)
            ->update(['lu' => true, 'lu_le' => now()]);

        // L'autre utilisateur
        $otherUser = $messages->first()->getOtherUser(auth()->id());

        // Toutes les conversations pour la sidebar
        $conversations = Message::getUserConversations(auth()->id());

        return view('chat.show', compact('messages', 'otherUser', 'conversations', 'conversationId'));
    }

    // Envoyer un message (API)
    // public function sendMessage(Request $request)
    // {
    //     $request->validate([
    //         'destinataire_id' => 'required|exists:users,id',
    //         'contenu' => 'required|string|max:5000',
    //         'piece_jointe' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt,xlsx,xls'
    //     ]);

    //     $messageData = [
    //         'expediteur_id' => auth()->id(),
    //         'destinataire_id' => $request->destinataire_id,
    //         'contenu' => $request->contenu,
    //         'type' => 'text'
    //     ];

    //     // Gestion de la pièce jointe
    //     if ($request->hasFile('piece_jointe')) {
    //         $file = $request->file('piece_jointe');
    //         $fileName = time() . '_' . $file->getClientOriginalName();
    //         $path = $file->store('messages/pieces-jointes', 'public');
    //         $messageData['piece_jointe'] = $path;
    //         $messageData['type'] = 'file';
    //     }

    //     $message = Message::create($messageData);

    //     // Retourner le message avec les relations
    //     $message->load(['expediteur', 'destinataire']);

    //     return response()->json([
    //         'success' => true,
    //         'message' => $message,
    //         'html' => view('chat.partials.message', compact('message'))->render()
    //     ]);
    // }


    // public function sendMessage(Request $request)
    // {
    //     // Validation
    //     $request->validate([
    //         'destinataire_id' => 'required|exists:users,id',
    //         'contenu' => 'nullable|string|max:5000',
    //         'piece_jointe' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt,xlsx,xls'
    //     ]);

    //     // Vérifier qu'il y a au moins du contenu OU un fichier
    //     if (!$request->contenu && !$request->hasFile('piece_jointe')) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Vous devez envoyer un message ou un fichier'
    //         ], 422);
    //     }

    //     $messageData = [
    //         'expediteur_id' => auth()->id(),
    //         'destinataire_id' => $request->destinataire_id,
    //         'contenu' => $request->contenu ?? '',
    //         'type' => 'text'
    //     ];

    //     // Gestion de la pièce jointe
    //     if ($request->hasFile('piece_jointe')) {
    //         try {
    //             $file = $request->file('piece_jointe');

    //             // Vérifier que le fichier est valide
    //             if ($file->isValid()) {
    //                 // Générer un nom unique
    //                 $fileName = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();

    //                 // Stocker le fichier
    //                 $path = $file->storeAs('messages/pieces-jointes', $fileName, 'public');

    //                 // Ajouter au message
    //                 $messageData['piece_jointe'] = $path;

    //                 // Déterminer le type
    //                 $extension = strtolower($file->getClientOriginalExtension());
    //                 if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
    //                     $messageData['type'] = 'image';
    //                 } else {
    //                     $messageData['type'] = 'file';
    //                 }

    //                 Log::info('Fichier uploadé avec succès: ' . $path);
    //             } else {
    //                 return response()->json([
    //                     'success' => false,
    //                     'message' => 'Le fichier est invalide'
    //                 ], 422);
    //             }
    //         } catch (\Exception $e) {
    //             Log::error('Erreur upload fichier: ' . $e->getMessage());

    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Erreur lors de l\'upload du fichier: ' . $e->getMessage()
    //             ], 500);
    //         }
    //     }

    //     // Créer le message
    //     $message = Message::create($messageData);

    //     // Charger les relations
    //     $message->load(['expediteur', 'destinataire']);

    //     return response()->json([
    //         'success' => true,
    //         'message' => $message,
    //         'html' => view('chat.partials.message', compact('message'))->render()
    //     ]);
    // }


    // public function sendMessage(Request $request)
    // {


    //     // Validation adaptée pour inclure l'audio
    //     $request->validate([
    //         'destinataire_id' => 'required|exists:users,id',
    //         'contenu' => 'nullable|string|max:5000',
    //         'piece_jointe' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt,xlsx,xls',
    //         'audio' => 'nullable|file|max:5120|mimes:mp3,wav,ogg,webm,m4a', // 5 MB max pour audio
    //         'audio_duration' => 'nullable|integer|min:1|max:600' // Max 10 minutes
    //     ]);

    //     // Vérifier qu'il y a au moins du contenu OU un fichier OU un audio
    //     if (!$request->contenu && !$request->hasFile('piece_jointe') && !$request->hasFile('audio')) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Vous devez envoyer un message, un fichier ou un audio'
    //         ], 422);
    //     }

    //     $messageData = [
    //         'expediteur_id' => auth()->id(),
    //         'destinataire_id' => $request->destinataire_id,
    //         'contenu' => $request->contenu ?? '',
    //         'type' => 'text'
    //     ];

    //     // Gestion de l'audio (prioritaire sur les fichiers normaux)
    //     if ($request->hasFile('audio')) {
    //         try {
    //             $audioFile = $request->file('audio');

    //             if ($audioFile->isValid()) {
    //                 // Générer un nom unique
    //                 $fileName = time() . '_' . uniqid() . '_audio.' . $audioFile->getClientOriginalExtension();

    //                 // Stocker dans un dossier dédié aux audios
    //                 $path = $audioFile->storeAs('messages/audios', $fileName, 'public');

    //                 // Ajouter au message
    //                 $messageData['piece_jointe'] = $path;
    //                 $messageData['type'] = 'audio';
    //                 $messageData['audio_duration'] = $request->audio_duration ?? 0;

    //                 // Si pas de contenu texte, mettre un message par défaut
    //                 if (empty($messageData['contenu'])) {
    //                     $messageData['contenu'] = '🎤 Message vocal';
    //                 }

    //                 Log::info('Audio uploadé avec succès: ' . $path);
    //             } else {
    //                 return response()->json([
    //                     'success' => false,
    //                     'message' => 'Le fichier audio est invalide'
    //                 ], 422);
    //             }
    //         } catch (\Exception $e) {
    //             Log::error('Erreur upload audio: ' . $e->getMessage());

    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Erreur lors de l\'upload de l\'audio: ' . $e->getMessage()
    //             ], 500);
    //         }
    //     }
    //     // Sinon, gestion des fichiers normaux
    //     elseif ($request->hasFile('piece_jointe')) {
    //         try {
    //             $file = $request->file('piece_jointe');

    //             if ($file->isValid()) {
    //                 $fileName = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
    //                 $path = $file->storeAs('messages/pieces-jointes', $fileName, 'public');

    //                 $messageData['piece_jointe'] = $path;

    //                 // Déterminer le type
    //                 $extension = strtolower($file->getClientOriginalExtension());
    //                 if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
    //                     $messageData['type'] = 'image';
    //                 } else {
    //                     $messageData['type'] = 'file';
    //                 }

    //                 Log::info('Fichier uploadé avec succès: ' . $path);
    //             } else {
    //                 return response()->json([
    //                     'success' => false,
    //                     'message' => 'Le fichier est invalide'
    //                 ], 422);
    //             }
    //         } catch (\Exception $e) {
    //             Log::error('Erreur upload fichier: ' . $e->getMessage());

    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Erreur lors de l\'upload du fichier: ' . $e->getMessage()
    //             ], 500);
    //         }
    //     }

    //     // Créer le message
    //     $message = Message::create($messageData);

    //     // Charger les relations
    //     $message->load(['expediteur', 'destinataire']);

    //     return response()->json([
    //         'success' => true,
    //         'message' => $message,
    //         'html' => view('chat.partials.message', compact('message'))->render()
    //     ]);
    // }


    public function sendMessage(Request $request)
{
    $request->validate([
        'destinataire_id' => 'required|exists:users,id',
        'contenu' => 'nullable|string|max:5000',
        'piece_jointe' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,txt,xlsx,xls',
        'audio' => 'nullable|file|max:5120|mimes:mp3,wav,ogg,webm,m4a',
        'audio_duration' => 'nullable|integer|min:1|max:600'
    ]);

    if (
        !$request->filled('contenu') &&
        !$request->hasFile('piece_jointe') &&
        !$request->hasFile('audio')
    ) {
        return response()->json([
            'success' => false,
            'message' => 'Message vide'
        ], 422);
    }

    $messageData = [
        'expediteur_id' => auth()->id(),
        'destinataire_id' => $request->destinataire_id,
        'contenu' => $request->contenu ?? '',
        'type' => 'text'
    ];

    /* ===== AUDIO ===== */
    if ($request->hasFile('audio')) {
        $file = $request->file('audio');
        $name = uniqid('audio_') . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('messages/audios', $name, 'public');

        $messageData['piece_jointe'] = $path;
        $messageData['type'] = 'audio';
        $messageData['audio_duration'] = $request->audio_duration ?? 0;
        $messageData['contenu'] = '🎤 Message vocal';
    }

    /* ===== IMAGE / FICHIER ===== */
    elseif ($request->hasFile('piece_jointe')) {
        $file = $request->file('piece_jointe');
        $name = uniqid() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('messages/pieces-jointes', $name, 'public');

        $ext = strtolower($file->getClientOriginalExtension());

        $messageData['piece_jointe'] = $path;
        $messageData['type'] = in_array($ext, ['jpg','jpeg','png','gif','webp'])
            ? 'image'
            : 'file';
    }

    $message = Message::create($messageData);
    $message->load(['expediteur', 'destinataire']);

    return response()->json([
        'success' => true,
        'message' => $message,
        'html' => view('chat.partials.message', compact('message'))->render()
    ]);
}


    // Récupérer les nouveaux messages d'une conversation
    public function getNewMessages($conversationId, $lastMessageId = 0)
    {
        $messages = Message::conversation($conversationId)
            ->where('id', '>', $lastMessageId)
            ->with(['expediteur', 'destinataire'])
            ->get();

        // Marquer comme lus
        Message::conversation($conversationId)
            ->where('destinataire_id', auth()->id())
            ->where('id', '>', $lastMessageId)
            ->where('lu', false)
            ->update(['lu' => true, 'lu_le' => now()]);

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'html' => view('chat.partials.messages', compact('messages'))->render()
        ]);
    }

    // Démarrer une nouvelle conversation
    public function newConversation($userId)
    {
        $otherUser = User::findOrFail($userId);

        // Générer l'ID de conversation
        $conversationId = Message::generateConversationId(auth()->id(), $userId);

        // Vérifier si une conversation existe déjà
        $existingMessage = Message::where('conversation_id', $conversationId)->first();

        if ($existingMessage) {
            return redirect()->route('chat.show', $conversationId);
        }

        // Créer une vue pour démarrer la conversation
        $conversations = Message::getUserConversations(auth()->id());
        $messages = collect();

        return view('chat.show', compact('messages', 'otherUser', 'conversations', 'conversationId'));
    }

    // Marquer un message comme lu
    public function markAsRead($messageId)
    {
        $message = Message::findOrFail($messageId);

        if ($message->destinataire_id === auth()->id()) {
            $message->marquerCommeLu();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 403);
    }

    // Rechercher dans les conversations
    public function search(Request $request)
    {
        $query = $request->get('q');

        $messages = Message::where(function($q) use ($query) {
                $q->where('expediteur_id', auth()->id())
                  ->orWhere('destinataire_id', auth()->id());
            })
            ->where(function($q) use ($query) {
                $q->where('contenu', 'like', "%{$query}%")
                  ->orWhereHas('expediteur', function($q) use ($query) {
                      $q->where('prenom', 'like', "%{$query}%")
                        ->orWhere('nom', 'like', "%{$query}%");
                  })
                  ->orWhereHas('destinataire', function($q) use ($query) {
                      $q->where('prenom', 'like', "%{$query}%")
                        ->orWhere('nom', 'like', "%{$query}%");
                  });
            })
            ->with(['expediteur', 'destinataire'])
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }
}
