<?php

namespace App\Http\Controllers\Scolarite;

use App\Models\Document;
use App\Models\Enseignant;
use App\Models\TypeDocument;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Eleve;
use Illuminate\Http\UploadedFile;
use Illuminate\View\View;

class DocumentController extends Controller
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
        $nomEleve = $eleve->nom . '-' . $eleve->prenom;
        $timestamp = Carbon::now()->timestamp;
        $extension = $file->getClientOriginalExtension();

        return $nomEleve . '-' . $timestamp . '.' . $extension;
    }
    /**
     * Display a listing of the resource.
     *
     * @param Eleve $eleve
     * @return View
     */
    public function index(Eleve $eleve): View
    {
        return view('web.scolarites.eleves.documents.index', compact('eleve'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Eleve $eleve): View
    {
        $types = TypeDocument::all();

        return view('web.scolarites.eleves.documents.create', compact('eleve','types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Eleve $eleve)
    {
        $request->validate([
            'nom'              => 'required|max:191',
            'description'      => 'required|max:191',
            'type_document_id' => 'required',
            'file'             => 'required',
        ]);

        // On enregistre le fichier
        $filename = $this->generateFilename($eleve, $request->file('file'));
        $request->file('file')->storeAs('public/documents/', $filename);

        $document = Document::create([
            'nom'              => $request->input('nom'),
            'description'      => $request->input('description'),
            'type_document_id' => $request->input('type_document_id'),
            'path'             => $filename,
            'eleve_id'         => $eleve->id
        ]);
        return redirect(route('web.scolarites.eleves.documents.index', $eleve->id));
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
