<?php

class Blog_post_comments_model extends DataMapper
{
    public $table = "blog_post_comments";

    public $has_one = array(
        'blog_post' => array(
            'class' => 'blog_posts_model',
            'other_field' => 'comments',
            'join_self_as' => 'comment',
            'join_other_as' => 'blog_post',
        ),
    );

}
