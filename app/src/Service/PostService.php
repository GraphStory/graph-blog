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

    public function getPosts($limit, $skip) {}

    public function getPostBySlug($slug) {
        return $this->postRepository->getBySlug($slug);
    }

    public function getPostBySlugWithEverything($slug) {
        return $this->postRepository->getBySlugWithEverything($slug);
    }

    public function getPostsByAuthor($username, $limit, $skip) {}

    public function getPostsByTag($tagSlug, $limit, $skip) {}

    public function getPostsByCategory($catSlug, $limit, $skip) {}
}
