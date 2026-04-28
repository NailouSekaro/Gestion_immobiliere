<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travail extends Model {
    use HasFactory;

    protected $fillable = [
        'property_id',
        'type_travail',
        'description',
        'prestataire_id',
        'date_travail',
        'total_depense'
    ];

    public function property() {
        return $this->belongsTo( Property::class );
    }

    public function depenses() {
        return $this->hasMany( DepenseTravail::class );
    }

    public function recalculerTotal() {
        $this->update( [
            'total_depense' => $this->depenses()->sum( 'montant' )
        ] );

    }

    public function prestataire() {
        return $this->belongsTo( User::class, 'prestataire_id' );
    }

}
