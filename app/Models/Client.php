<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $primaryKey = 'client_id';
    protected $fillable = ['personne_id'];



    public function commandes(): HasMany
    {
        return $this->hasMany(Commande::class);
    }


    public function personnes(): BelongsTo
    {
        return $this->belongsTo(Personne::class,'personne_id');
    }



}
