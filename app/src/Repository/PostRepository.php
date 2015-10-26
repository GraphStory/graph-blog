<?php

namespace GraphBlog\Repository;

use GraphBlog\Model\Post;
use Neoxygen\NeoClient\Client;
use Psr\Log\LoggerInterface;

class PostRepository extends AbstractRepository
{
    /**
     * @var \Neoxygen\NeoClient\Client
     */
    protected $client;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    public function __construct(Client $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    public function getBySlug($slug)
    {
        $cql = "
        MATCH (p:Post {slug: {slug} })
        RETURN p;
        ";
        $params = compact('slug');
        $response = $this->client->sendCypherQuery($cql, $params);
        $result = $response->getResult();
        $node = $result->getSingleNode();
        if ($node) {
            return Post::fromArray($node->getProperties());
        }
        return null;
   }
}