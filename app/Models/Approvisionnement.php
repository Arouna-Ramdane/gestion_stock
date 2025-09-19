<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approvisionnement extends Model
{
    protected $primaryKey = 'appro_id';
    protected $fillable = ['qte_appro','date_appro','produit_id'];
}
