<?php

namespace GraphBlog\Model;

use \stdClass;

class Author extends AbstractModel
{
    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string
     */
    public $lastName;

    /**
     * @param array $props
     * @return Author
     */
    public static function fromArray(array $props)
    {
        $author = new Author;
        $author->username = $props['username'];
        $author->email = $props['email'];
        $author->firstName = $props['firstName'];
        $author->lastName = $props['lastName'];
        return $author;
    }

    /**
     * @param stdClass $obj
     * @return Author
     */
    public static function fromObject(stdClass $obj)
    {
        $author = new Author;
        $author->username = $obj->username;
        $author->email = $obj->email;
        $author->firstName = $obj->firstName;
        $author->lastName = $obj->lastName;
        return $author;
    }
}
