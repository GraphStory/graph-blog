<?php

namespace GraphBlog\Model;

use \stdClass;

class Tag extends AbstractModel
{
    /**
     * @var string
     */
    public $slug;

    /**
     * @var string
     */
    public $title;

    /**
     * @param array $props
     * @return Tag
     */
    public static function fromArray(array $props)
    {
        $tag = new Tag;
        $tag->slug = $props['slug'];
        $tag->title = $props['title'];
        return $tag;
    }

    /**
     * @param stdClass $obj
     * @return Tag
     */
    public static function fromObject(stdClass $obj)
    {
        $tag = new Tag;
        $tag->slug = $obj->slug;
        $tag->title = $obj->title;
        return $tag;
    }

    /**
     * @return array
     */
    public function JsonSerialize()
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
        ];
    }
}
