<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCommentsVotes extends Model
{
    use HasFactory;

    protected $table = 'users_comments_votes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment_id', 'user_id', 'vote'
    ];

    public function user(){
        return $this->belongsTo('\App\Models\User');
    }

    public function comment(){
        return $this->belongsTo('\App\Models\Comment');
    }
}
