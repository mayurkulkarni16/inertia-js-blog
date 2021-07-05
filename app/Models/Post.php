<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'body', 'title', 'hide'];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id')->where('hide', 0)->limit(3)->orderBy('id', 'desc');
    }

    public function allComments()
    {
        return $this->hasMany(Comment::class, 'post_id')->where('hide', 0)->orderBy('id', 'desc');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
