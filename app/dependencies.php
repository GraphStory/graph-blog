<?php
// DIC configuration

$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------

// Twig
$container['view'] = function ($c) {
    $settings = $c->get('settings');
    $view = new \Slim\Views\Twig($settings['view']['template_path'], $settings['view']['twig']);

    // Add extensions
    $view->addExtension(new Slim\Views\TwigExtension($c->get('router'), $c->get('request')->getUri()));
    $view->addExtension(new Twig_Extension_Debug());

    return $view;
};

// Flash messages
$container['flash'] = function ($c) {
    return new \Slim\Flash\Messages;
};

// -----------------------------------------------------------------------------
// Service factories
// -----------------------------------------------------------------------------

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings');
    $logger = new \Monolog\Logger($settings['logger']['name']);
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['logger']['path'], \Monolog\Logger::DEBUG));
    return $logger;
};

// neoClient
$container['neoClient'] = function ($c) {
    $settings = $c->get('settings');
    $client = \Neoxygen\NeoClient\ClientBuilder::create()
        ->addConnection(
            $settings['neo4j']['alias'],
            $settings['neo4j']['protocol'],
            $settings['neo4j']['host'],
            $settings['neo4j']['port'],
            $settings['neo4j']['authmode'],
            $settings['neo4j']['username'],
            $settings['neo4j']['password']
        )
        ->setDefaultTimeout($settings['neo4j']['timeout'])
        ->setLogger('neoClient', $c->get('logger'))
        ->setAutoFormatResponse(true)
        ->build();
    return $client;
};

// postService
$container['postService'] = function ($c) {
    $authorRepo = new \GraphBlog\Repository\AuthorRepository();
    $categoryRepo = new \GraphBlog\Repository\CategoryRepository();
    $postRepo = new \GraphBlog\Repository\PostRepository(
        $c->get('neoClient'),
        $c->get('logger')
    );
    $tagRepo = new \GraphBlog\Repository\TagRepository();
    $postService = new \GraphBlog\Service\PostService(
        $postRepo,
        $authorRepo,
        $categoryRepo,
        $tagRepo,
        $c->get('logger')
    );
    return $postService;
};


// -----------------------------------------------------------------------------
// Action factories
// -----------------------------------------------------------------------------

$container['GraphBlog\Action\HomeAction'] = function ($c) {
    return new GraphBlog\Action\HomeAction($c->get('view'), $c->get('logger'));
};
