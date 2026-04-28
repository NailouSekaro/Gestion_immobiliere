<?php

namespace App\Models;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caution extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'property_id',
        'caution_chambre',
        'caution_eau',
        'caution_electricite',
        'total_caution',
        'methode',
        'date_paiement',
        'statut',
    ];




        protected static function booted()
    {
        static::creating(function ($caution) {
            $caution->reference = 'CAU-' . strtoupper(Str::random(8));
            $caution->verification_token = Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
