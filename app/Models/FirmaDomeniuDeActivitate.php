<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirmaDomeniuDeActivitate extends Model
{
    use HasFactory;

    protected $table = 'firme_domenii_de_activitate';
    protected $guarded = [];

    public function path()
    {
        return "/firme/domenii-de-activitate/{$this->id}";
    }
}
