<?php

namespace GraphBlog\Model;

use \StdClass;


abstract class AbstractModel
{
    public abstract function JsonSerialize();

    public static abstract function fromArray(array $props);

    public static abstract function fromObject(stdClass $props);
}