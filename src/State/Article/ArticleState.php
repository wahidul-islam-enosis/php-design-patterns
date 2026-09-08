<?php

declare(strict_types=1);

namespace Patterns\State\Article;

interface ArticleState
{
    public function edit(Article $article, string $content): void;

    public function submit(Article $article): void;

    public function approve(Article $article): void;

    public function reject(Article $article): void;

    public function name(): string;
}
