<?php

declare(strict_types=1);

use Patterns\State\Article\Article;
use Patterns\State\Article\InMemoryTransitionLogger;

require_once __DIR__ . '/../vendor/autoload.php';

$logger = new InMemoryTransitionLogger();

$article = new Article(
    content: "This is a demo content",
    logger: $logger
);

displayArticle($article);

$article->edit("This is the updated content");

displayArticle($article);

$article->submit();

displayArticle($article);

$article->reject();

displayArticle($article);

$article->edit("This is the final version");

displayArticle($article);

$article->submit();

displayArticle($article);

$article->approve();

displayArticle($article);

print_r($logger->transitions());

function displayArticle(Article $article)
{
    echo $article->status() . PHP_EOL;
    print($article);
}
