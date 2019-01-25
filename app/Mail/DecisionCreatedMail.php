<?php

namespace App\Mail;

use App\Models\Decision;
use App\Models\Eleve;
use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class DecisionCreatedMail extends Mailable
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
	 * @var Decision $decision
	 */
	private $decision;

	/**
	 * Créer une instance de EleveCreatedMail
	 *
	 * @param Eleve    $eleve
	 * @param Decision $decision
	 */
	public function __construct(Eleve $eleve, Decision $decision)
	{
		$this->eleve = $eleve;
		$this->decision = $decision;
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
		$subject = "GEMAH - 3.00 - [{$types}] - Nouvelle décision pour {$this->eleve->nom} {$this->eleve->prenom}";

		return $this->from("dsi-bureautique42@ac-lyon.fr")->bcc($this->emails)->subject($subject)->view('emails.scolarites.eleves.decisions.create')->with([
			"eleve"    => $this->eleve,
			"decision" => $this->decision,
		]);
	}
}
