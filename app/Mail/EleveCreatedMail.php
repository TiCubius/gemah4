<?php

namespace App\Mail;

use App\Models\Eleve;
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
		$this->emails = Utilisateur::all()->pluck("email");
	}


	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->from("no-reply@gemah.fr")->to($this->emails)->view('emails.scolarites.eleves.create')->with([
				"eleve" => $this->eleve,
			]);
	}
}
