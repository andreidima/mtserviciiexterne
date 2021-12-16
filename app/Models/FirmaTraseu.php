<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirmaTraseu extends Model
{
    use HasFactory;

    protected $table = 'firme_trasee';
    protected $guarded = [];

    public function path()
    {
        return "/firme/trasee/{$this->id}";
    }

    /**
     * Get all of the firme for the FirmaTraseu
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function firme()
    {
        return $this->hasMany(Firma::class, 'traseu_id', 'id');
    }
}
