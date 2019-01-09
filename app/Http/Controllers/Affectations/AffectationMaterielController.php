<?php

namespace App\Http\Controllers\Affectations;

use App\Http\Controllers\Controller;
use App\Models\Eleve;
use App\Models\Responsable;
use Illuminate\Http\Request;

class AffectationMaterielController extends Controller
{
    public function index()
    {

        return view("web.affectations.materiels");
    }

    public function attach()
    {
        return redirect();
    }

    public function detach()
    {
        return redirect();
    }
}
