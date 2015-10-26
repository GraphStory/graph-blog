<?php

namespace GraphBlog\Model;

use \StdClass;


abstract class AbstractModel implements \JsonSerializable
{
    public static abstract function fromArray(array $props);

    public static abstract function fromObject(stdClass $props);
}