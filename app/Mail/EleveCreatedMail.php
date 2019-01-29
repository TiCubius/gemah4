<?php

namespace App\Mail;

use App\Models\Eleve;
use App\Models\Service;
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
			$this->emails = $this->emails->merge($service->utilisateurs->where('reception_email', 1)->pluck('email'));
		}
	}


	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		$subject = "GEMAH - 3.00 - Nouvel(le) élève : {$this->eleve->nom} {$this->eleve->prenom}";

		return $this->from("dsi-bureautique42@ac-lyon.fr")->bcc($this->emails)->subject($subject)->view('emails.scolarites.eleves.create')->with([
			"eleve" => $this->eleve,
		]);
	}
}
