<?php

namespace App\Http\Resources\Comment;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'post_id' => $this->post_id,
            'author_id' => $this->author_id,
            'comment' => $this->comment,
            'votes' => $this->votes,
            'links' => [
                'post' => route( 'posts.show', $this->post_id ),
            ]
        ];
    }
}
