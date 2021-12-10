<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Gate;

class CarteScanata extends Model
{
    use HasFactory;

    protected $table = 'carti_scanate';
    protected $guarded = [];

    // protected $appends = ['acces'];

    public function path()
    {
        return "/carti-scanate/{$this->id}";
    }

    /**
     * Get the utilizator that owns the CarteScanata
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function utilizator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    //define accessor
    public function getAccesAttribute()
    {
        return 1;
    }
}
