<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservatiePoza extends Model
{
    use HasFactory;

    protected $table = 'observatii_poze';
    protected $guarded = [];

    public function path()
    {
        return "/observatii/poze/{$this->id}";
    }

    /**
     * Get the observatie that owns the Poza
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function observatie()
    {
        return $this->belongsTo(Observatie::class, 'observatie_id', 'id');
    }
}
