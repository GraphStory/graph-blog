<?php

namespace GraphBlog\Service;

use GraphBlog\Repository\AuthorRepository;
use GraphBlog\Repository\CategoryRepository;
use GraphBlog\Repository\PostRepository;
use GraphBlog\Repository\TagRepository;

class Post
{
    public function __construct(
        PostRepository $postRepository,
        AuthorRepository $authorRepository,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository
    )
    {

    }

    public function getPosts() {}

    public function getPost() {}

    public function getPostWithEverything() {}

    public function getPostByAuthor() {}

    public function getPostsByTag() {}

    public function getPostsByCategory() {}
}
