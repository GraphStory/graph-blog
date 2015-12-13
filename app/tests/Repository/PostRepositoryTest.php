<?php

namespace GraphBlog\Repository;

require_once '../bootstrap.php';

/**
 * Created by PhpStorm.
 * User: coj
 * Date: 10/26/15
 * Time: 1:49 PM
 */
class PostRepositoryTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {

        $this->repository = new PostRepository(

        );
    }
}
