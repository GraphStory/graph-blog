<?php

namespace GraphBlog\Repository;

use GraphBlog\Model\Author;
use GraphBlog\Model\Category;
use GraphBlog\Model\Post;
use GraphBlog\Model\Tag;
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

    public function getBySlugWithEverything($slug)
    {
        $cql = "
        MATCH (p:Post {slug: {slug} })-[:TAGGED_WITH]->(t:Tag),
        (p)-[:CATEGORIZED_AS]->(c:Category),
        (p)-[:AUTHORED_BY]->(a:Author)
        RETURN p, COLLECT(t) as tags, COLLECT(c) as categories, a;
        ";

        $params = compact('slug');
        $response = $this->client->sendCypherQuery($cql, $params);
        $result = $response->getResult();
        if ($result->getNodesCount() > 0) {
            /*
             * We build an array of properties
             */
            $props = $result->getSingleNode('Post')->getProperties();

            $props['categories'] = [];
            foreach ($result->getNodesByLabel('Category') as $catNode) {
                $props['categories'][] = Category::fromArray($catNode->getProperties());
            }

            $props['tags'] = [];
            foreach ($result->getNodesByLabel('Tag') as $tagNode) {
                $props['tags'][] = Tag::fromArray($tagNode->getProperties());
            }

            $props['author'] = Author::fromArray($result->getSingleNode('Author')->getProperties());

            return Post::fromArray($props);
        }

        return null;
   }
}
