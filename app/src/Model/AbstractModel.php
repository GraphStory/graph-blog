<?php

namespace GraphBlog\Model;

use \StdClass;


abstract class AbstractModel implements \JsonSerializable
{
    /**
     * apparently you can't have abstract static methods
     * @param array $props
     */
    public static function fromArray(array $props) {}

    /**
     * apparently you can't have abstract static methods
     * @param StdClass $props
     */
    public static function fromObject(stdClass $props) {}
}