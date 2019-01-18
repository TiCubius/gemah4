<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Decision extends Model
{
    protected $fillable = [
        "document_id",
        "enseignant_id",
        "date_cda",
        "date_notification",
        "date_limite",
        "date_convention",
        "numero_dossier",
    ];

    protected $dates = [
        "date_cda",
        "date_notification",
        "date_limite",
        "date_convention",
    ];


	/***
	 * Une décision est liée a un document
	 *
	 * @return BelongsTo
	 */
	public function document(): BelongsTo
	{
		return $this->belongsTo(Document::class);
	}

    /***
     * Une décision est liée a un enseignant
     *
     * @return BelongsTo
     */
    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }
}
