<?php

namespace App\Repositories\Contracts;

interface CommentRepositoryInterface {

    public function findAllCommentsBlongsToPost($post_id);
    public function get_count_votes_comment($comment_id);
    public function get_user_comment_votes($comment_id);
    public function addOneVote($comment_id);
    public function subtractOneVote($comment_id);
    public function all();
    public function store($input);
    public function get($input);
    public function update($input);
    public function destroy($input);
    public function isUserComment($input);
}
