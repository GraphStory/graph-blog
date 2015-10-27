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
     * @var Tag[]
     */
    public $tags = [];

    /**
     * @var Category[]
     */
    public $categories = [];

    /**
     * @var Author
     */
    public $author;

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
        if (!empty($props['tags'])) {
            $post->setTags($props['tags']);
        }
        if (!empty($props['categories'])) {
            $post->setCategories($props['categories']);
        }
        if (!empty($props['author'])) {
            $post->setAuthor($props['author']);
        }
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
        if (!empty($obj->tags)) {
            $post->setTags($obj->tags);
        }
        if (!empty($obj->categories)) {
            $post->setCategories($obj->categories);
        }
        if (!empty($obj->author)) {
            $post->setAuthor($obj->author);
        }

        return $post;
    }

    /**
     * @param Author $author
     */
    protected function setAuthor(Author $author)
    {
        $this->author = $author;
    }

    /**
     * @param array $tags  An array of \GraphBlog\Model\Tag objects
     */
    protected function setTags(array $tags)
    {
        $this->tags = [];
        foreach ($tags as $tag) {
            if (!$tag instanceof Tag) {
                throw new \UnexpectedValueException('Tag value must be an instance of Tag');
            }
            $this->tags[] = $tag;
        }
    }

    /**
     * @param array $categories  An array of \GraphBlog\Model\Category objects
     */
    protected function setCategories(array $categories)
    {
        $this->categories = [];
        foreach ($categories as $category) {
            if (!$category instanceof Category) {
                throw new \UnexpectedValueException('category value must be an instance of Category');
            }
            $this->categories[] = $category;
        }
    }

    /**
     * a version specific to Post that handles author, tags and categories
     * @return array
     */
    public function toArray()
    {
        $arr = [
            'title' => $this->title,
            'slug' => $this->slug,
            'date' => $this->date,
            'body' => $this->body,
            'author' => $this->author->toArray(),
            'tags' => [],
            'categories' => [],
        ];

        foreach($this->tags as $tag) {
            $arr['tags'] = $tag->toArray();
        }

        foreach($this->categories as $category) {
            $arr['categories'] = $category->toArray();
        }
        return $arr;
    }
}
