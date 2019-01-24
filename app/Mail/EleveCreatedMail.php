<?php

namespace App\Mail;

use App\Models\Eleve;
use App\Models\Service;
use App\Models\Utilisateur;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class EleveCreatedMail extends Mailable
{
	use Queueable, SerializesModels;

	/**
	 * @var Collection $emails
	 */
	private $emails;

	/**
	 * @var Eleve $eleve
	 */
	private $eleve;

	/**
	 * Créer une instance de EleveCreatedMail
	 *
	 * @param Eleve $eleve
	 */
	public function __construct(Eleve $eleve)
	{
		$this->eleve = $eleve;
		$this->emails = collect();

		$services = Service::where("departement_id", $eleve->departement_id)->get();
		foreach ($services as $service) {
			$this->emails = $this->emails->merge($service->utilisateurs->pluck('email'));
		}

	}


	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		$types = join(" / ", $this->eleve->types->pluck("libelle")->toArray());
		$subject = "GEMAH - 3.00 - [{$types}] - Nouvel élève : {$this->eleve->nom} {$this->eleve->prenom}";

		return $this->from("dsi-bureautique42@ac-lyon.fr")->to($this->emails)->subject($subject)->view('emails.scolarites.eleves.create')->with([
			"eleve" => $this->eleve,
		]);
	}
}
