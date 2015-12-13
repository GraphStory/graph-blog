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

    public function getBySlug($slug, $extended = true)
    {
        if ($extended) {
            return $this->getBySlugExtended($slug);
        }
        $cql = "
        MATCH (post:Post {slug: {slug} })
        RETURN post;
        ";

        $params = compact('slug');
        $response = $this->client->sendCypherQuery($cql, $params);
        $result = $response->getResult();
        if ($result->getNodesCount() > 0) {
            return $this->postTableFormatToModels($result->getTableFormat())[0];
        }
        return null;
   }

    public function getBySlugExtended($slug)
    {
        $cql = "
        MATCH (post:Post {slug: {slug} })-[:TAGGED_WITH]->(t:Tag),
        (post)-[:CATEGORIZED_AS]->(c:Category),
        (post)-[:AUTHORED_BY]->(author:Author)
        RETURN post, COLLECT(DISTINCT t) as tags, COLLECT(DISTINCT c) as categories, author;
        ";

        $params = compact('slug');
        $response = $this->client->sendCypherQuery($cql, $params);
        $result = $response->getResult();
        if ($result->getNodesCount() > 0) {
            return $this->postExtendedTableFormatToModels($result->getTableFormat())[0];
        }
        return null;
    }

    public function getPosts($limit = 10, $skip = 0, $extended = false)
    {
        /*
         * we have to cast these here because the parameterized input only works within node properties AFAICT
         */
        $limit = (int)$limit;
        $skip = (int)$skip;

        if ($extended) {
            return $this->getPostsExtended($limit, $skip);
        }

        $cql = "
        MATCH (post:Post)
        ORDER BY post.date
        return post
        SKIP {$skip}
        LIMIT {$limit};
        ";
        $response = $this->client->sendCypherQuery($cql);
        $result = $response->getResult();
        if ($result->getNodesCount() > 0) {
            return $this->postTableFormatToModels($result->getTableFormat());
        }
        return null;

    }

    public function getPostsExtended($limit = 10, $skip = 0)
    {
        $cql = "
        MATCH (post:Post)-[:TAGGED_WITH]->(t:Tag),
        (post)-[:CATEGORIZED_AS]->(c:Category),
        (post)-[:AUTHORED_BY]->(author:Author)
        RETURN post, COLLECT(DISTINCT t) as tags, COLLECT(DISTINCT c) as categories, author
        ORDER BY post.date
        SKIP {$skip}
        LIMIT {$limit};
        ";
        $response = $this->client->sendCypherQuery($cql);
        $result = $response->getResult();
        if ($result->getNodesCount() > 0) {
            return $this->postExtendedTableFormatToModels($result->getTableFormat());
        }
        return null;
    }

    protected function postTableFormatToModels($tableResults)
    {
        $posts = [];
        foreach ($tableResults as $row) {
            $posts[] = Post::fromArray($row['post']);
        }
        return $posts;
    }


    protected function postExtendedTableFormatToModels($tableResults)
    {
        $posts = [];
        foreach ($tableResults as $row) {
            $props = $row['post'];
            $props['categories'] = [];
            foreach ($row['categories'] as $categoryArray) {
                $props['categories'][] = Category::fromArray($categoryArray);
            }
            $props['tags'] = [];
            foreach ($row['tags'] as $tagArray) {
                $props['tags'][] = Tag::fromArray($tagArray);
            }
            $props['author'] = Author::fromArray($row['author']);
            $posts[] = Post::fromArray($props);
        }
        return $posts;
    }
}
