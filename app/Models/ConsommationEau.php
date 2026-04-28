<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsommationEau extends Model
{

    protected $table = 'consommation_eaux';

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'property_id',
        'index_compteur',
        'index_precedent',
        // 'index_actuel',
        'consommation',
        'prix_m3',
        'montant',
        'periode_debut',
        'periode_fin',
        'statut'
    ];

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}


    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function paiement()
    {
        return $this->hasOne(PaiementEau::class);
    }

    public function paiementEau()
    {
        return $this->hasOne(PaiementEau::class, 'consommation_eau_id');
    }

    protected $casts = [
    'periode_debut' => 'date',
    'periode_fin'   => 'date',
    'date_paiement' => 'datetime',
];
 use HasFactory;
}

