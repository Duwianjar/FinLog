<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $fillable = [
        'like_type',
        'id_user',
        'id_story',
        'id_comennt',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function story()
    {
        return $this->belongsTo(Story::class, 'id_story');
    }
    public function comment()
    {
        return $this->belongsTo(Comment::class, 'id_comment');
    }
}