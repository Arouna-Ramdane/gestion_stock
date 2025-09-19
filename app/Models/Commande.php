<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;



class Commande extends Model
{


    protected $primaryKey = 'commande_id';
    protected $fillable = ['dateCommande', 'prix_total', 'user_id','client_id'];


   public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class,'client_id');
    }

     public function LigneCommandes(): HasMany
    {
        return $this->hasMany(LigneCommande::class);
    }
}
