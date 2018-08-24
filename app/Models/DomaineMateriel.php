<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DomaineMateriel extends Model
{
    public $table = "domaines_materiel";
    protected $fillable = ["nom"];
}
