<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Personne extends Model
{

    protected $primaryKey = 'personne_id';
    protected $fillable = ['first_name','name','contact','adresse'];

    public function users(): HasOne
    {
        return $this->hasOne(User::class, 'personne_id');
    }

    public function clients(): HasOne
    {
        return $this->hasOne(Client::class, 'client_id');
    }
}
