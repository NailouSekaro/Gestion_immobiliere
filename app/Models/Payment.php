<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'user_id',
        'property_id',
        'reference',
        'montant',
        'devise',
        'mois_paye',
        'annee',
        'periode',
        'methode',
        'operateur',
        'numero_transaction',
        'statut',
        'paye_le',
        'date_limite',
        'date_paiement',
        'notes',
        'metadata',
        'preuve_paiement'
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_limite' => 'date',
        'date_paiement' => 'datetime',
        'paye_le' => 'datetime',
        'metadata' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            $payment->uuid = Str::uuid();
            $payment->reference = $payment->generateReference();
        });
    }

    // Générer une référence unique
    public function generateReference()
    {
        return 'PAY-' . date('Ymd') . '-' . Str::upper(Str::random(6));
    }

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // Scopes
    public function scopePayes($query)
    {
        return $query->where('statut', 'paye');
    }

    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopePourMois($query, $mois, $annee)
    {
        return $query->where('mois_paye', $annee . '-' . str_pad($mois, 2, '0', STR_PAD_LEFT));
    }

    public function scopePourUtilisateur($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Méthodes utilitaires
    public function estEnRetard()
    {
        return $this->statut === 'en_attente' && now()->greaterThan($this->date_limite);
    }

    public function marquerCommePaye($datePaiement = null)
    {
        $this->update([
            'statut' => 'paye',
            'paye_le' => $datePaiement ?? now(),
            'date_paiement' => $datePaiement ?? now()
        ]);
    }

    public function getJoursRetardAttribute()
    {
        if ($this->estEnRetard()) {
            return now()->diffInDays($this->date_limite);
        }
        return 0;
    }

    public function getMontantAvecPenaliteAttribute()
    {
        $penalite = 0;
        if ($this->estEnRetard()) {
            // Exemple: 5% de pénalité par mois de retard
            $penalite = $this->montant * 0.05 * ceil($this->jours_retard / 30);
        }
        return $this->montant + $penalite;
    }

    // Méthode pour créer un paiement mensuel
    public static function creerPaiementMensuel(User $user, Property $property, $mois, $annee)
    {
        $moisPaye = $annee . '-' . str_pad($mois, 2, '0', STR_PAD_LEFT);
        $periode = self::getNomMois($mois) . ' ' . $annee;

        return self::create([
            'user_id' => $user->id,
            'property_id' => $property->id,
            'montant' => $property->loyer_mensuel,
            'mois_paye' => $moisPaye,
            'annee' => $annee,
            'periode' => $periode,
            'date_limite' => now()->setDate($annee, $mois, 5)->endOfDay(), // 5 du mois
            'statut' => 'en_attente'
        ]);
    }

    public static function getNomMois($mois)
    {
        $moisNoms = [
            1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
            5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
            9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
        ];
        return $moisNoms[$mois] ?? 'Inconnu';
    }


   protected static function booted()
{
    static::creating(function ($payment) {
        $payment->verification_token = Str::uuid();
    });
}

// public function dernierPaiement()
// {
//     return $this->hasOne(Payment::class)
//         ->where('statut', 'paye')
//         ->latestOfMany('mois_paye');
// }


}
