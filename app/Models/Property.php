<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'nom',
        'adresse',
        'ville',
        'pays',
        'type',
        'nombre_pieces',
        'surface',
        'caracteristiques',
        'loyer_mensuel',
        'caution',
        'devise',
        'date_disponibilite',
        'statut',
        'notes'
    ];

    protected $casts = [
        'caracteristiques' => 'array',
        'loyer_mensuel' => 'decimal:2',
        'caution' => 'decimal:2',
        'date_disponibilite' => 'date'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($property) {
            $property->uuid = \Illuminate\Support\Str::uuid();
        });
    }

    // Relation avec le locataire actuel
    // public function locataireActuel()
    // {
    //     return $this->hasOne(User::class, 'property_id')
    //         ->where('role', 'locataire')
    //         ->where('est_actif', true);
    // }

    // Méthode pour mettre à jour automatiquement le statut
public function updateStatut()
    {
        $hasLocataire = $this->locataireActuel()->exists();

        $this->update([
            'statut' => $hasLocataire ? 'occupé' : 'libre'
        ]);
    }

// Modifie la relation locataireActuel pour qu'elle soit plus précise
public function locataireActuel()
    {
        return $this->hasOne(User::class, 'property_id')
            ->where('role', 'locataire')
            ->where('est_actif', true);
    }

    // Relation avec tous les locataires (historique)
    public function locataires()
    {
        return $this->hasMany(User::class, 'property_id')
            ->where('role', 'locataire');
    }

    // Relation avec les paiements
    public function paiements()
    {
        return $this->hasMany(Payment::class);
    }

    // Scope pour les propriétés libres
    // public function scopeLibres($query)
    // {
    //     return $query->where('statut', 'libre');
    // }

    // // Scope pour les propriétés occupées
    // public function scopeOccupees($query)
    // {
    //     return $query->where('statut', 'occupé');
    // }

    // Méthode pour calculer le loyer annuel
    public function getLoyerAnnuelAttribute()
    {
        return $this->loyer_mensuel * 12;
    }

    // Méthode pour vérifier la disponibilité
    public function estDisponible()
    {
        return $this->statut === 'libre' && $this->date_disponibilite <= now();
    }


    // Scope pour les propriétés libres
public function scopeLibres($query)
    {
        return $query->where('statut', 'libre')
                    ->where('date_disponibilite', '<=', now());
    }

// Scope pour les propriétés occupées
public function scopeOccupees($query)
    {
        return $query->where('statut', 'occupé');
    }

// Scope pour les propriétés en maintenance
public function scopeEnMaintenance($query)
    {
        return $query->where('statut', 'maintenance');
    }

        public function travaux()
    {
        return $this->hasMany(Travail::class);
    }

}
