<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeDocument extends Model
{
    protected $table = "types_documents";
    protected $fillable = ["libelle"];
}
