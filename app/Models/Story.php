<?php
// In your Story model
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
        'allow_comments',
        'id_user',
    ];

    /**
     * Get the user that owns the depository.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_story')->latest();
    }
    public function commentlikes()
    {
        return $this->hasMany(Comment::class, 'id_story')
                    ->withCount('likes')
                    ->orderBy('likes_count', 'desc');
    }

    // di model Comment
    public function likes()
    {
        return $this->hasMany(Like::class, 'id_story')->latest();
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($story) {
            if (!$story->created_at) {
                $story->created_at = now()->subHours(17);
            }
        });

        static::updating(function ($story) {
            if (!$story->updated_at) {
                $story->updated_at = now()->subHours(17);
            }
        });
    }
}