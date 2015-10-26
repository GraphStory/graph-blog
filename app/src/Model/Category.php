<?php

namespace GraphBlog\Model;

use \stdClass;

class Category extends AbstractModel implements \JsonSerializable
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
     * @return Category
     */
    public static function fromArray(array $props)
    {
        $category = new Category;
        $category->slug = $props['slug'];
        $category->title = $props['title'];
        return $category;
    }

    /**
     * @param StdClass $obj
     * @return Category
     */
    public static function fromObject(stdClass $obj)
    {
        $category = new Category;
        $category->slug = $obj->slug;
        $category->title = $obj->title;
        return $category;
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
