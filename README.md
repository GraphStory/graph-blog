# Data class structure

Service -> Repository
Repository returns Model or array of Models



# Basic entities
```
Post
- slug
- title
- date
- body

Tag
- title
- slug

Category
- title
- slug

Author
- username
- email
- firstName
- lastName
```

# Constraints

```
CREATE CONSTRAINT ON (p:Post) ASSERT p.slug IS UNIQUE;
CREATE CONSTRAINT ON (t:Tag) ASSERT t.title IS UNIQUE;
CREATE CONSTRAINT ON (t:Tag) ASSERT t.slug IS UNIQUE;
CREATE CONSTRAINT ON (c:Category) ASSERT c.title IS UNIQUE;
CREATE CONSTRAINT ON (c:Category) ASSERT c.slug IS UNIQUE;
CREATE CONSTRAINT ON (a:Author) ASSERT a.username IS UNIQUE;
CREATE CONSTRAINT ON (a:Author) ASSERT a.email IS UNIQUE;
```

# Data

```
MERGE (p:Post {
        slug:'my-first-blog-post',
        title:'My First Blog Post',
        date:1445724363,
        body: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
    }
) return p;

MERGE (t:Tag {title:'Mental Health', slug:'mental-health'}) return t;

MERGE (c:Category {title:'General', slug:'general'}) return c;

MERGE (a:Author {username:'funkatron', email:'coj@funkatron.com', firstName:'Ed', lastName:'Finkler'}) return a;
```

# Relationships

```
MATCH (p:Post {slug:'my-first-blog-post'}), (a:Author {username:'funkatron'})
MERGE (p)-[r:AUTHORED_BY]->(a)
RETURN p,r,a;

MATCH (p:Post {slug:'my-first-blog-post'}), (t:Tag {slug:'mental-health'})
MERGE (p)-[r:TAGGED_WITH]->(t)
RETURN p,r,t;

MATCH (p:Post {slug:'my-first-blog-post'}), (c:Category {slug:'general'})
MERGE (p)-[r:CATEGORIZED_AS]->(c)
RETURN p,r,c;
```


# GraphGen spec

```
(p:Post {slug: slug, title: sentence, date: unixTime, body: paragraph} *20)
(t:Tag {title: sentence, slug: slug} *15)
(c:Category {title: sentence, slug: slug} *5)
(a:Author {username: username, email: email, firstName: firstName, lastName: lastName} *2)
(p)-[:AUTHORED_BY *n..1]->(a *1)
(p)-[:TAGGED_WITH *n..n]->(t *2)
(p)-[:CATEGORIZED_AS *n..n]->(c *1)
```

# Queries

## Get a post with all related data

```
MATCH (p:Post {slug:'modi-aperiam-eos-eveniet-quas'})-[:TAGGED_WITH]->(t:Tag),
(p)-[:CATEGORIZED_AS]->(c:Category),
(p)-[:AUTHORED_BY]->(a:Author)
RETURN p, COLLECT(t) as tags, COLLECT(c) as categories, a;
```