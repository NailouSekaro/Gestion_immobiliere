<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class Contract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'user_id',
        'property_id',
        'numero_contrat',
        'date_debut',
        'date_fin',
        'duree_mois',
        'loyer_mensuel',
        'caution',
        'devise',
        'termes',
        'clauses_speciales',
        'statut',
        'date_signature',
        'date_resiliation',
        'fichier_pdf',
        'signature_locataire',
        'signature_proprio'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'date_signature' => 'date',
        'date_resiliation' => 'date',
        'loyer_mensuel' => 'decimal:2',
        'caution' => 'decimal:2',
        'clauses_speciales' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($contract) {
            $contract->uuid = Str::uuid();
            $contract->numero_contrat = $contract->generateContractNumber();
        });
    }

    // Générer le numéro de contrat
    public function generateContractNumber()
    {
        return 'CONT-' . date('Ymd') . '-' . Str::upper(Str::random(4));
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
    public function scopeActifs($query)
    {
        return $query->where('statut', 'actif');
    }

    public function scopeExpires($query)
    {
        return $query->where('statut', 'expire');
    }

    public function scopePourLocataire($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Méthodes utilitaires
    public function estActif()
    {
        return $this->statut === 'actif' && $this->date_fin >= now();
    }

    public function estExpire()
    {
        return $this->date_fin < now();
    }

    public function joursRestants()
    {
        if ($this->estExpire()) {
            return 0;
        }
        return now()->diffInDays($this->date_fin);
    }

    public function getDureeContratAttribute()
    {
        // Ensure both dates are Carbon instances
        $start = \Carbon\Carbon::parse($this->date_debut);
        $end = \Carbon\Carbon::parse($this->date_fin);
        return $start->diffInMonths($end);
    }

    public function getLoyerAnnuelAttribute()
    {
        return $this->loyer_mensuel * 12;
    }

    // Méthode pour générer le PDF
    public function genererPdf()
    {
        $pdf = Pdf::loadView('admin.contracts.templates.default', ['contract' => $this]);

        $filename = 'contrat-' . $this->numero_contrat . '.pdf';
        $path = 'contracts/' . $filename;

        // Sauvegarder le fichier
        Storage::disk('public')->put($path, $pdf->output());

        $this->update(['fichier_pdf' => $path]);

        return $path;
    }
}
