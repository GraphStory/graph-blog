<?php
// Routes

$app->get('/', 'GraphBlog\Action\HomeAction:dispatch')
    ->setName('homepage');

$app->get('/post', function ($request, $response, $args) {
    $container = $this->getContainer();
    /** @var  $postService */
    $postService = $container->get('postService');
    $post = $postService->getPostBySlug('modi-aperiam-eos-eveniet-quas', true)->toArray();
    // var_export($postService->getPostBySlug('modi-aperiam-eos-eveniet-quas', true)->toArray());
    // echo "<hr>";
    // var_dump($postService->getPosts(10, 0, true));

    return $this->view->render(
        $response,
        'pages/post.twig',
        compact('post')
    );
})->setName('get-post');

$app->get('/posts', function ($request, $response, $args) {
    $container = $this->getContainer();
    /** @var  $postService */
    $postService = $container->get('postService');
    $posts = $postService->getPosts(10, 0, true);

    return $this->view->render(
        $response,
        'pages/posts.twig',
        $post
    );
})->setName('get-post');
