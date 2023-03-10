<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id', 'author_id', 'comment', 'vote'
    ];
    
    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }

    public function users_comments_votes(){
        return $this->hasMany('\App\Models\UserCommentsVotes');
    }
}
