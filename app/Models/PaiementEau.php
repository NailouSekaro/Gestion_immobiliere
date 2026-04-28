<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaiementEau extends Model
{
    protected $table = 'paiement_eaux';
    protected $fillable = [
        'consommation_eau_id',
        'montant_paye',
        'methode',
        'date_paiement'
    ];

    public function consommation()
    {
        return $this->belongsTo(ConsommationEau::class, 'consommation_eau_id');
    }
}

