<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Gate;

class SsmFirma extends Model
{
    use HasFactory;

    protected $table = 'ssm_firme';
    protected $guarded = [];

    public function path()
    {
        return "/ssm/firme/{$this->id}";
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
}
