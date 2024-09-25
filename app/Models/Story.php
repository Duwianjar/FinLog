<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;
    protected $fillable = [
        'photo',
        'caption',
        'count_update',
        'allow_coments',
        'id_user',
    ];

    /**
     * Get the user that owns the depository.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}