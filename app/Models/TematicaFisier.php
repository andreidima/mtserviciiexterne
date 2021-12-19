<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TematicaFisier extends Model
{
    use HasFactory;

    protected $table = 'tematici_fisiere';
    protected $guarded = [];

    public function path()
    {
        return "/tematici/fisiere/{$this->id}";
    }

    /**
     * Get the tematica that owns the TematicaFisier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tematica()
    {
        return $this->belongsTo(Tematica::class, 'tematica_id', 'id');
    }
}
