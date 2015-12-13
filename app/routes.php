<?php
// Routes

$app->get('/', 'GraphBlog\Action\HomeAction:dispatch')
    ->setName('homepage');

$app->get('/post/{postSlug}', function ($request, $response, $args) {

    $postSlug = $args['postSlug'];

    /** @var  $postService */
    $postService = $this->get('postService');
    $post = $postService->getPostBySlug($postSlug, true)->toArray();

    return $this->view->render(
        $response,
        'pages/post.twig',
        compact('post')
    );
})->setName('get-post');

$app->get('/posts', function ($request, $response, $args) {
    /** @var  $postService */
    $postService = $this->get('postService');
    $posts = $postService->getPosts(10, 0, true);

    return $this->view->render(
        $response,
        'pages/posts.twig',
        compact('posts')
    );
})->setName('get-posts');
