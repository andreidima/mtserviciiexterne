<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Gate;

class FirmaSalariat extends Model
{
    use HasFactory;

    protected $table = 'firme_salariati';
    protected $guarded = [];

    public function path()
    {
        return "/firme/salariati/{$this->id}";
    }

    /**
     * Get the domeniu_de_activitate that owns the FirmaSalariat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function domeniu_de_activitate()
    {
        return $this->belongsTo(FirmaSalariat::class, 'firma_id', 'id');
    }
}
