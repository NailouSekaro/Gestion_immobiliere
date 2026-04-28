<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable {
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'uuid',
        'nom',
        'prenom',
        'email',
        'password',
        'telephone',
        'role',
        'specialite',
        'photo_profil',
        'est_actif',
        'property_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'secret_2fa',
        'codes_recuperation_2fa'
    ];

    protected $casts = [
        'email_verifie_le' => 'datetime',
        '2fa_confirme_le' => 'datetime',
        'derniere_connexion' => 'datetime',
        'verrouille_jusqu' => 'datetime',
        'est_actif' => 'boolean',
        'last_seen_at' => 'datetime',
    ];

    // Méthodes pour vérifier les rôles
    // public function isSuperAdmin()
    // {
    //     return $this->role === 'super_admin';
    // }

    public function isAdmin() {
        return $this->role === 'admin';
    }

    public function isLocataire() {
        return $this->role === 'locataire';
    }

    public function isPrestataire() {
        return $this->role === 'prestataire';
    }

    use Notifiable;

    public function routeNotificationForMail() {
        return $this->email;
    }

    // Ajoute ces méthodes dans la classe User

    // Messages reçus

    public function receivedMessages() {
        return $this->hasMany( Message::class, 'destinataire_id' );
    }

    // Messages envoyés

    public function sentMessages() {
        return $this->hasMany( Message::class, 'expediteur_id' );
    }

    // Scope pour les messages non lus

    public function unreadMessages() {
        return $this->receivedMessages()->where( 'lu', false );
    }

    // Derniers messages reçus

    public function latestReceivedMessages( $limit = 5 ) {
        return $this->receivedMessages()
        ->with( 'expediteur' )
        ->orderBy( 'created_at', 'desc' )
        ->take( $limit )
        ->get();
    }

    // Compter les messages non lus

    public function getUnreadMessagesCountAttribute() {
        return $this->unreadMessages()->count();
    }

    // public function isOnline() {
    //     return Cache::has( 'user-is-online-' . $this->id );
    // }

    // public function isOnline() {
    //     return \Cache::has( 'user-online-' . $this->id );
    // }

    //     public function isOnline()
    // {
    //     if ( !$this->last_seen_at ) {
    //         return false;
    //     }

    //     return $this->last_seen_at->gt( now()->subMinutes( 5 ) );
    // }

    // Dans app/Models/User.php

    public function isOnline() {
        // Vérifier d'abord le cache (rapide)
    if (Cache::has('user-online-' . $this->id)) {
        return true;
    }

    // Sinon vérifier la BDD (fallback)
    if ($this->last_seen_at) {
        return $this->last_seen_at->gt(now()->subMinutes(5));
    }

    return false;
}
/**
 * Obtenir le temps écoulé depuis la dernière activité
 */
public function getLastSeenAttribute()
{
    if (!$this->last_seen_at) {
        return 'Jamais vu';
    }

    if ($this->isOnline()) {
        return 'En ligne';
    }

    return 'Vu ' . $this->last_seen_at->diffForHumans();
}


public function markAsOnline()
{
    $this->update(['last_seen_at' => now()]);
    Cache::put('user-online-' . $this->id, true, now()->addMinutes(5));
}

    // public function paiements()
    // {
    //     return $this->hasMany( Payment::class );
    // }

    public function property() {
        return $this->belongsTo( Property::class, 'property_id' );
    }

    public function hasRole() {
        return $this->role === 'admin';
    }

    public function consommationsEau() {
        return $this->hasMany( ConsommationEau::class );
    }

    // App\Models\User.php

    public function paiements() {
        return $this->hasMany( Payment::class, 'user_id' );
    }

    //     public function payments()
    // {
    //     return $this->hasMany( Payment::class );
    // }

    public function dernierPaiement() {
        return $this->hasOne( Payment::class )
        ->where( 'statut', 'paye' )
        ->latestOfMany( 'mois_paye' );
    }

    public function travaux()
{
    return $this->hasMany(Travail::class, 'prestataire_id' );
    }

}
