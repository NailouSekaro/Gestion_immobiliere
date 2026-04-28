<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepenseTravail extends Model
{
    use HasFactory;

    protected $fillable = [
        'travail_id',
        'libelle',
        'montant',
        'date_depense'
    ];

    public function travail()
    {
        return $this->belongsTo(Travail::class);
    }
}
