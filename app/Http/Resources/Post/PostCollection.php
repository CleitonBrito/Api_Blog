<?php

namespace App\Http\Resources\Post;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $posts = [];
        foreach ( $this->resource as $post ) {
            $posts[] = [
                'id' => $post->id,
                'user' => $post->user_id,
                'title' => $post->title,
                'slug' => $post->slug,
                'content' => $post->content,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
                'links' => [
                    'post' => route( 'posts.show', $post->id )
                ]
            ];
        }
        
        return $posts;
    }
}
