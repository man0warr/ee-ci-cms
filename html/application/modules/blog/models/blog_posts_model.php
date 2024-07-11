<?php

class Blog_posts_model extends DataMapper
{
    public $table = "blog_posts";

    public $has_many = array(
        'comments' => array(
            'class' => 'blog_post_comments_model',
            'other_field' => 'blog_post',
            'join_self_as' => 'blog_post',
            'join_other_as' => 'comment',
        ),
    );

}
