<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ConnexionController extends Controller
{
    /**
     * GET - Affiche la page de connexion à GEMAH
     *
     * @return View
     */
    public function index(): View
    {
        return view('web.connexion');
    }

    /**
     * POST - Vérifie les informations soumises par l'utilisateur, et le connecte si correcte
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        $user = Utilisateur::where('pseudo', $request->input('pseudo'))->first();

        // On vérifie si l'utilisateur n'existe pas ou si son mot de passe est incorrect
        if ((!$user) || !Hash::check($request->input('password'), $user->password)) {
            return redirect(route('web.connexion'))->withErrors('Pseudo ou Mot de passe incorrect');
        }

        // L'utilisateur existe et son mot de passe est correct
        Session::put('user', $user);

        // On redirige sur la page d'accueil
        return redirect(route('web.index'));
    }

    /**
     * GET - Déconnecte l'utilisateur et supprime les infos de Session
     * @return RedirectResponse
     */
    public function logout (): RedirectResponse
    {
        Session::flush();
        return redirect(route('web.connexion'));
    }
}
