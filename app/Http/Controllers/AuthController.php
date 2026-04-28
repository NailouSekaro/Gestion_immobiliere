<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\PasswordResetMail;
use App\Models\User;
use App\Notifications\SecurityAlertNotification;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // Affiche le formulaire de connexion

    public function showLoginForm()
    {
        return view('home');
    }

    // Traite la connexion

    // public function login( Request $request ) {
    //     $credentials = $request->validate( [
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ] );

    //     if ( Auth::attempt( $credentials ) ) {
    //         $request->session()->regenerate();

    //         // Vérifie si le mot de passe doit être changé ( ex: champ `password_changed_at` null )
    //         if ( is_null( Auth::user()->password_changed_at ) ) {
    //             return redirect()->route( 'password.reset' );
    //         }

    //         return redirect()->intended( 'dashboard' );
    //     }

    //     return back()->withErrors( [ 'email' => 'Identifiants invalides.', 'password' => 'Identifiants invalides.' ] )
    //     ->withInput( $request->only( 'email', 'remember' ) );
    // }

    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate();

    //         return redirect()->intended('dashboard');
    //     }

    //     return back()->withErrors( [ 'email' => 'Identifiants invalides.', 'password' => 'Identifiants invalides.' ] )
    //     ->withInput( $request->only( 'email', 'remember' ) );
    // }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Vérifier si l'utilisateur existe et est actif
        $user = User::where('email', $request->email)->first();

        if ($user && !$user->est_actif) {
            return back()->withErrors(['email' => 'Votre compte est désactivé.']);
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Mise à jour des infos de connexion
            $user->update([
                'derniere_connexion' => now(),
                'ip_derniere_connexion' => $request->ip(),
                'tentatives_connexion_echouees' => 0,
            ]);

            // Détection de connexion suspecte
            $lastIp = $user->ip_derniere_connexion;
            $currentIp = $request->ip();

            if ($lastIp && $lastIp !== $currentIp) {
                $user->notify(new SecurityAlertNotification('nouvelle_connexion', $currentIp, $request->userAgent()));
            }

            // Vérifier si le mot de passe doit être changé
            if (is_null($user->password_changed_at)) {
                return redirect()->route('password.reset');
            }

            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        // Quand l'utilisateur se connecte
        Cache::put('user-is-online-' . Auth::id(), true, now()->addMinutes(5));

        // Gestion des tentatives échouées
        $this->handleFailedLogin($request);

        return back()
            ->withErrors(['email' => 'Identifiants invalides.', 'password' => 'Identifiants invalides.'])
            ->withInput($request->only('email', 'remember'));
    }

    private function handleFailedLogin(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user->increment('tentatives_connexion_echouees');

            // Verrouiller le compte après 5 tentatives
            if ($user->tentatives_connexion_echouees >= 5) {
                $user->update([
                    'verrouille_jusqu' => now()->addMinutes(30),
                ]);
            }
        }
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Aucun utilisateur trouvé avec cet email.']);
        }

        if (!$user->est_actif) {
            return back()->withErrors(['email' => 'Votre compte est désactivé.']);
        }

        // Générer un token de réinitialisation
        $token = Str::random(60);

        // Sauvegarder le token dans la base de données
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ],
        );

        // Envoyer l'email de réinitialisation
        try {
            Mail::to($user->email)->send(new PasswordResetMail($user, $token));

            return back()->with('status', 'Un lien de réinitialisation a été envoyé à votre adresse email.');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Erreur lors de l\'envoi de l\'email.']);
        }
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:12|regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
        ]);

        // Vérifier le token
        $resetData = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$resetData || !Hash::check($request->token, $resetData->token)) {
            return back()->withErrors(['email' => 'Token invalide ou expiré.']);
        }

        // Vérifier si le token a expiré (1 heure)
        if (Carbon::parse($resetData->created_at)->addHour()->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Le token a expiré.']);
        }

        // Mettre à jour le mot de passe
        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password),
            'password_changed_at' => now(),
            'tentatives_connexion_echouees' => 0,
            'verrouille_jusqu' => null,
        ]);

        // Supprimer le token utilisé
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Connecter automatiquement l'utilisateur
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Mot de passe réinitialisé avec succès.');
    }

    // public function index()
    // {
    //     if (Auth::check() && is_null(Auth::user()->password_changed_at)) {
    //         return redirect()->route('password.reset.form');
    //     }

    //     return view('dashboard');
    // }

    // public function index()
    // {
    //     return view('dashboard');
    // }

    //     public function login( Request $request ) {
    //     $credentials = $request->only( 'email', 'password' );
    //     dd( Auth::attempt( $credentials ) );
    // Doit retourner 'true' ou 'false'
    //     // ...
    // }

    // Déconnexion

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        // Quand il se déconnecte
        Cache::forget('user-is-online-' . Auth::id());
        return redirect('login');
    }

    // public function showResetForm()
    // {
    //     return view('auth.force-reset');
    // }

    // public function reset(Request $request)
    // {
    //     $request->validate([
    //         'current_password' => ['required', 'current_password'],
    //         'new_password'     => [
    //             'required',
    //             'confirmed',
    //             'min:12',
    //             'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
    //         ],
    //     ], [
    //         'current_password.required' => 'Veuillez entrer votre mot de passe actuel.',
    //         'current_password.current_password' => 'Le mot de passe actuel est incorrect.',
    //         'new_password.confirmed'    => 'La confirmation ne correspond pas.',
    //         'new_password.min'          => 'Le mot de passe doit contenir au moins 12 caractères.',
    //         'new_password.regex'        => 'Le mot de passe doit contenir au moins une majuscule, un chiffre et un caractère spécial.',
    //     ]);

    //     $user = Auth::user();
    //     $user->update([
    //         'password'=> Hash::make($request->new_password),
    //         'password_changed_at'=> now(),
    //     ]);

    //     return redirect()->route('dashboard')->with('success_message', 'Mot de passe changé avec succès.');
    // }

    // public function reset(Request $request)
    // {
    //     $request->validate(
    //         [
    //             'current_password' => ['required', 'current_password'],
    //             'new_password' => ['required', 'confirmed', 'min:12', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
    //         ],
    //         [
    //             'new_password.confirmed' => 'La confirmation ne correspond pas.',
    //             'new_password.min' => 'Le mot de passe doit contenir au moins 12 caractères.',
    //             'new_password.regex' => 'Le mot de passe doit contenir au moins une majuscule, un chiffre et un caractère spécial.',
    //         ],
    //     );

    //     Auth::user()->update([
    //         'password' => Hash::make($request->new_password),
    //         'password_changed_at' => now(),
    //     ]);

    //     return redirect()->route('dashboard')->with('success_message', 'Mot de passe changé avec succès.');
    // }

    // public function reset(Request $request)
    // {
    //     $request->validate([
    //         'current_password' => ['required', 'current_password'],
    //         'new_password' => ['required', 'confirmed', 'min:12', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
    //     ]);

    //     Auth::user()->update([
    //         'password' => Hash::make($request->new_password),
    //         'password_changed_at' => now(),
    //     ]);

    //     return redirect()->route('dashboard')->with('success_message', 'Mot de passe mis à jour.');
    // }

    // public function reset( Request $request ) {
    //     $request->validate( [ 'password' => 'required|confirmed|min:8' ] );

    //     $user = Auth::user();
    //     $user->password = Hash::make( $request->password );
    //     $user->password_changed_at = now();
    //     $user->save();

    //     return redirect( '/dashboard' )->with( 'success_message', 'Mot de passe mis à jour.' );
    // }

    // public function login( Request $request )
    // {
    //     $credentials = $request->validate( [
    //         'email' => 'required|email',
    //         'password' => 'required|min:8',
    // ] );

    //     if ( Auth::attempt( $credentials ) ) {
    //         return redirect()->intended( 'dashboard' );
    //     }

    //     return redirect()->back()->with( 'error_message', 'Paramètre de connexion invalide' );
    // }

    // public function login( Request $request )
    // {
    //         // Valider les champs
    //         $request->validate( [
    //             'email' => 'required|email',
    //             'password' => 'required|string|min:8',
    // ] );

    //         // Vérifier si le compte est verrouillé
    //         if ( $this->hasTooManyLoginAttempts( $request ) ) {
    //             $this->fireLockoutEvent( $request );
    //             return $this->sendLockoutResponse( $request );
    //         }

    //         // Tentative de connexion
    //         if ( Auth::attempt( $request->only( 'email', 'password' ), $request->filled( 'remember' ) ) ) {
    //             $request->session()->regenerate();
    //             RateLimiter::clear( $this->throttleKey( $request ) );

    //             // Mettre à jour les infos de connexion
    //             $user = Auth::user();
    //             $user->update( [
    //                 'derniere_connexion' => now(),
    //                 'ip_derniere_connexion' => $request->ip(),
    //                 'tentatives_connexion_echouees' => 0
    // ] );

    //             // Redirection selon le rôle
    //             return $this->authenticated( $request, $user );
    //         }

    //         // Incrémenter les tentatives échouées
    //         RateLimiter::hit( $this->throttleKey( $request ) );

    //         $user = \App\Models\User::where( 'email', $request->email )->first();
    //         if ( $user ) {
    //             $user->increment( 'tentatives_connexion_echouees' );
    //             if ( $user->tentatives_connexion_echouees >= 5 ) {
    //                 $user->update( [ 'verrouille_jusqu' => now()->addHours( 2 ) ] );
    //             }
    //         }

    //         return back()->withErrors( [
    //             'email' => __( 'auth.failed' ),
    // ] );
    //     }

    //     protected function authenticated( Request $request, $user )
    // {
    //         if ( $user->isSuperAdmin() || $user->isAdmin() ) {
    //             return redirect()->route( 'admin.dashboard' );
    //         }

    //         if ( $user->isGestionnaire() ) {
    //             return redirect()->route( 'gestionnaire.dashboard' );
    //         }

    //         return redirect()->route( 'lecteur.dashboard' );
    //     }

    //     protected function hasTooManyLoginAttempts( Request $request )
    // {
    //         return RateLimiter::tooManyAttempts(
    //             $this->throttleKey( $request ), 5
    // );
    //     }

    //     protected function throttleKey( Request $request )
    // {
    //         return mb_strtolower( $request->input( 'email' ) ).'|'.$request->ip();
    //     }
}
