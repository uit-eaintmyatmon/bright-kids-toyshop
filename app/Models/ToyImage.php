<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToyImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'toy_id',
        'image_url',
        'sort_order',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function toy()
    {
        return $this->belongsTo(Toy::class);
    }
}
