<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    protected $primaryKey = 'depense_id';

    protected $fillable = ['motif','montant','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
