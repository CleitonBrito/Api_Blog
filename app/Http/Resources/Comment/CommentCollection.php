<?php

namespace App\Http\Resources\Comment;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $comments = [];
        foreach ($this->resource as $comment) {
            $comments[] = [
                'id' => $comment->id,
                'post_id' => $comment->post_id,
                'author_id' => $comment->author_id,
                'comment' => $comment->comment,
                'votes' => $comment->votes,
                'links' => [
                    'post' => route( 'posts.show', $comment->post_id ),
                    'comment' => route( 'comments.show', $comment->id )
                ]
            ];
        }
    
        return $comments;
    }
}