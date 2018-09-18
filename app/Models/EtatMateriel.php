<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtatMateriel extends Model
{
    public $table = "etats_materiel";
    protected $fillable = ["nom"];
}
