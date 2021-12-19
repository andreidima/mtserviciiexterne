<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tematica extends Model
{
    use HasFactory;

    protected $table = 'tematici';
    protected $guarded = [];

    public function path()
    {
        return "/tematici/{$this->id}";
    }

    /**
     * Get all of the fisiere for the Tematica
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fisiere()
    {
        return $this->hasMany(TematicaFisier::class, 'tematica_id', 'id');
    }
}
