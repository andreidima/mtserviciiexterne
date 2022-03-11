<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SsmSalariat extends Model
{
    use HasFactory;

    protected $table = 'ssm_salariati';
    protected $guarded = [];

    public function path()
    {
        return "ssm/salariati/{$this->id}";
    }
}
