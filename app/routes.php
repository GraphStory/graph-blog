<?php
// Routes

$app->get('/', 'GraphBlog\Action\HomeAction:dispatch')
    ->setName('homepage');
