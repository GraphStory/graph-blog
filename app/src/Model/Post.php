<?php

namespace GraphBlog\Model;

use \stdClass;

class Post extends AbstractModel
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $slug;

    /**
     * @var integer
     */
    public $date;

    /**
     * @var string
     */
    public $body;


    /**
     * @param array $props
     * @return Post
     */
    public static function fromArray(array $props)
    {
        $post = new Post;
        $post->title = $props['title'];
        $post->slug = $props['slug'];
        $post->date = $props['date'];
        $post->body = $props['body'];
        return $post;
    }

    /**
     * @param stdClass $obj
     * @return Post
     */
    public static function fromObject(stdClass $obj)
    {
        $post = new Post;
        $post->title = $obj->title;
        $post->slug = $obj->slug;
        $post->date = $obj->date;
        $post->body = $obj->body;
        return $post;
    }

    /**
     * @return array
     */
    public function JsonSerialize()
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'date' => $this->date,
            'body' => $this->body,
        ];
    }
}
