<?php

namespace App\Http\Controllers\Scolarite;

use App\Models\Decision;
use App\Models\Document;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\TypeDocument;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DecisionController extends Controller
{
    /**
     * PRIVATE - Génère un nom de fichier avec les données envoyées
     *
     * @param Eleve $eleve
     * @param UploadedFile $file
     * @return string
     */
    private function generateFilename(Eleve $eleve, UploadedFile $file): string
    {
        $nom = $eleve->nom . '-' . $eleve->prenom;
        $timestamp = Carbon::now()->timestamp;
        $extension = $file->getClientOriginalExtension();

        return $nom . '-' . $timestamp . '.' . $extension;
    }

    /**
     * GET - Affiche le formulaire de création d'une Décision
     *
     * @param Eleve $eleve
     * @return View
     */
    public function create(Eleve $eleve): View
    {
        $enseignants = Enseignant::all();

        return view('web.scolarites.eleves.documents.decisions.create', compact('eleve', 'enseignants'));
    }

    /**
     * POST - Enregistre la décision et le document associé
     *
     * @param  \Illuminate\Http\Request $request
     * @param Eleve $eleve
     * @return RedirectResponse
     */
    public function store(Request $request, Eleve $eleve): RedirectResponse
    {
        $request->validate([
            'date_limite'     => 'required|date|nullable',
            'date_cda'        => 'nullable|date',
            'date_notif'      => 'nullable|date',
            'date_convention' => 'nullable|date',
            'numero_dossier'  => 'nullable|max:191',
            'enseignant_id'   => 'nullable|integer',
            'nom_suivi'       => 'nullable|string|max:191',
            'file'            => 'required'
        ]);

            // On enregistre le fichier
            $filename = $this->generateFilename($eleve, $request->file('file'));
            $request->file('file')->storeAs('public/decisions/', $filename);

            $document = Document::create([
                'nom'              => "Décision du " .Carbon::parse($request->input('date_notif'))->format('d/m/Y'),
                'description'      => $request->input('description'),
                'type_document_id' => TypeDocument::where('nom', 'Décision')->first()->id,
                'path'             => $filename,
                'eleve_id'         => $eleve->id
            ]);


        Decision::create([
            'date_cda'        => $request->input('date_cda'),
            'date_notif'      => $request->input('date_notif'),
            'date_limite'     => $request->input('date_limite'),
            'date_convention' => $request->input('date_convention'),
            'numero_dossier'  => $request->input('numero_dossier'),
            'nom_suivi'       => $request->input('nom_suivi'),

            'eleve_id'      => $eleve->id,
            'enseignant_id' => $request->input('enseignant_id'),
            'document_id'   => $document->id,
        ]);

        return redirect(route('web.scolarites.eleves.documents.index', [$eleve]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * GET - Affiche le formulaire d'édition d'une décision
     *
     * @param Eleve $eleve
     * @param Decision $decision
     * @return \Illuminate\Http\Response
     */
    public function edit(Eleve $eleve, Decision $decision)
    {
        $enseignants = Enseignant::all();

        return view('web.scolarites.eleves.documents.decisions.edit', compact('eleve', 'decision', 'enseignants'));
    }

    /**
     * PATCH - Met à jour la décision et le document asocié
     *
     * @param  \Illuminate\Http\Request $request
     * @param Eleve $eleve
     * @param Decision $decision
     * @return RedirectResponse
     */
    public function update(Request $request, Eleve $eleve, Decision $decision): RedirectResponse
    {
        $request->validate([
            'date_limite'     => 'required|date|nullable',
            'date_cda'        => 'nullable|date',
            'date_notif'      => 'nullable|date',
            'date_convention' => 'nullable|date',
            'numero_dossier'  => 'nullable|max:191',
            'enseignant_id'   => 'nullable|integer',
            'nom_suivi'       => 'nullable|string|max:191',
        ]);

        if ($request->hasFile('file')) {
            // On supprime l'ancien fichier
            if ($decision->document !== NULL) {
                Storage::delete('public/' . $decision->document->path);
                $decision->document()->delete();
            }

            // On enregistre le fichier
            $filename = $this->generateFilename($eleve, $request->file('file'));
            $request->file('file')->storeAs('public/decisions/', $filename);

            $document =Document::create([
                'type_document_id'     => TypeDocument::where('nom', 'Décision')->first()->id,
                'path'     => $filename,
                'eleve_id' => $eleve->id,
            ]);
        }

        $decision->update([
            'date_cda'        => $request->input('date_cda'),
            'date_notif'      => $request->input('date_notif'),
            'date_limite'     => $request->input('date_limite'),
            'date_convention' => $request->input('date_convention'),
            'numero_dossier'  => $request->input('numero_dossier'),
            'nom_suivi'       => $request->input('nom_suivi'),
            'eleve_id'        => $eleve->id,
            'enseignant_id'   => $request->input('enseignant_id'),
            'document_id'     => isset($document) ? $document->id : $decision->document_id,
        ]);

        return redirect(route('web.scolarites.eleves.documents.index', [$eleve]));
    }

    /**
     * DELETE - Supprime la décision et le document associé
     *
     * @param Eleve $eleve
     * @param Decision $decision
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Eleve $eleve, Decision $decision): RedirectResponse
    {
        Storage::delete('public/documents/' . $decision->document->path);
        $decision->document()->delete();
        $decision->delete();

        return redirect(route("web.scolarites.eleves.documents.index", [$eleve]));
    }
}
