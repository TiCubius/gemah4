<?php

namespace App\Mail;

use App\Models\Decision;
use App\Models\Eleve;
use App\Models\Utilisateur;
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
		$this->emails = Utilisateur::all()->pluck("email");
	}


	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->from("no-reply@gemah.fr")->to($this->emails)->view('emails.scolarites.eleves.decisions.create')->with([
			"eleve"    => $this->eleve,
			"decision" => $this->decision,
		]);
	}
}
