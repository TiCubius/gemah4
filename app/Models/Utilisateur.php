<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    protected $fillable = [
        "nom",
	    "prenom",
	    "email",
	    "password",
	    "academie_id",
	    "service_id",
    ];
}
