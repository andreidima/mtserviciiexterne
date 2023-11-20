<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observatie extends Model
{
    use HasFactory;

    protected $table = 'observatii';
    protected $guarded = [];

    public function path()
    {
        return "/observatii/{$this->id}";
    }

    /**
     * Get the firma that owns the Observatie
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function firma()
    {
        return $this->belongsTo(SsmFirma::class, 'firma_id', 'id');
    }

    /**
     * Get all of the poze for the Observatie
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function poze()
    {
        return $this->hasMany(ObservatiePoza::class, 'observatie_id', 'id');
    }
}
