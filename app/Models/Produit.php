<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Produit extends Model
{

    protected $primaryKey = 'produit_id';
    protected $fillable = ['libelle', 'prix', 'quantiteStock','image'];

    public function LigneCommandes(): HasMany
    {
        return $this->hasMany(LigneCommande::class);
    }
}
