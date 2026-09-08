<?php

declare(strict_types=1);

namespace Patterns\State\Article;

use DomainException;
use Override;

final class PublishedState implements ArticleState
{
    #[Override]
    public function edit(Article $article, string $content): void
    {
        throw new DomainException("Published article cannot be edited");
    }

    #[Override]
    public function submit(Article $article): void
    {
        throw new DomainException("Published article cannot be edited");
    }

    #[Override]
    public function approve(Article $article): void
    {
        throw new DomainException("Published article cannot be approved");
    }

    #[Override]
    public function reject(Article $article): void
    {
        throw new DomainException("Published article cannot be rejected");
    }

    #[Override]
    public function name(): string
    {
        return 'published';
    }
}
