<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirmaTraseu extends Model
{
    use HasFactory;

    protected $table = 'firme_stingatoare';
    protected $guarded = [];

    public function path()
    {
        return "/firme/stingatoare/{$this->id}";
    }

    /**
     * Get the firma that owns the FirmaStingator
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function firma()
    {
        return $this->belongsTo(Firma::class, 'firma_id', 'id');
    }
}
