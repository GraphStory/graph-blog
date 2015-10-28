<?php

namespace GraphBlog\Service;

use GraphBlog\Repository\AuthorRepository;
use GraphBlog\Repository\CategoryRepository;
use GraphBlog\Repository\PostRepository;
use GraphBlog\Repository\TagRepository;
use Psr\Log\LoggerInterface;

class PostService
{
    public function __construct(
        PostRepository $postRepository,
        AuthorRepository $authorRepository,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository,
        LoggerInterface $logger
    )
    {
        $this->postRepository = $postRepository;
        $this->authorRepository = $authorRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
        $this->logger = $logger;
    }

    public function getPosts($limit = 10, $skip = 0, $extended = false) {
        return $this->postRepository->getPosts($limit, $skip, $extended);
    }

    public function getPostBySlug($slug, $extended = false) {
        return $this->postRepository->getBySlug($slug, $extended);
    }

    public function getPostsByAuthor($username, $limit = 10, $skip = 0) {
        return $this->postRepository->getPostsByAuthor($username, $limit, $skip);
    }

    public function getPostsByTag($tagSlug, $limit = 10, $skip = 0) {
        return $this->postRepository->getPostsByTag($tagSlug, $limit, $skip);
    }

    public function getPostsByCategory($catSlug, $limit = 10, $skip = 0) {}
}
