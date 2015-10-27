<?php
// Routes

$app->get('/', 'GraphBlog\Action\HomeAction:dispatch')
    ->setName('homepage');

$app->get('/post', function($request, $response, $args) {
    $container = $this->getContainer();
    /** @var  $postService */
    $postService = $container->get('postService');
    var_dump($postService->getPostBySlugWithEverything('modi-aperiam-eos-eveniet-quas'));
})->setName('get-post');
