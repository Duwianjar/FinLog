<?php
// In your Comment model
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_story',
        'id_user',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function story()
    {
        return $this->belongsTo(Story::class, 'id_story');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($comment) {
            if (!$comment->created_at) {
                $comment->created_at = now()->subHours(5);
            }
        });

        static::updating(function ($comment) {
            if (!$comment->updated_at) {
                $comment->updated_at = now()->subHours(5);
            }
        });
    }
}