<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Gate;

class Firma extends Model
{
    use HasFactory;

    protected $table = 'firme';
    protected $guarded = [];

    public function path()
    {
        return "firme/{$this->id}";
    }

    /**
     * Get the domeniu_de_activitate that owns the Firma
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function domeniu_de_activitate()
    {
        return $this->belongsTo(FirmaDomeniuDeActivitate::class, 'domeniu_de_activitate_id', 'id');
    }

    /**
     * Get the traseu that owns the Firma
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function traseu()
    {
        return $this->belongsTo(FirmaTraseu::class, 'traseu_id', 'id');
    }

    /**
     * Get all of the salariati for the Firma
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function salariati()
    {
        return $this->hasMany(FirmaSalariat::class, 'firma_id', 'id');
    }

    /**
     * Get the stingator associated with the Firma
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function stingator()
    {
        return $this->hasOne(FirmaStingator::class, 'firma_id', 'id');
    }

    /**
     * The tematici that belong to the Firma
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tematici()
    {
        return $this->belongsToMany(Tematica::class, 'firma_tematica', 'firma_id', 'tematica_id');
    }
}
