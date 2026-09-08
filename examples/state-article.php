<?php

declare(strict_types=1);

use Patterns\State\Article\Article;

require_once __DIR__ . '/../vendor/autoload.php';

$article = new Article("This is a demo content");

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

function displayArticle(Article $article)
{
    echo $article->status() . PHP_EOL;
    print($article);
}
