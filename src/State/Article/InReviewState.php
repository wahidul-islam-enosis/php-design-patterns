<?php

declare(strict_types=1);

namespace Patterns\State\Article;

use DomainException;
use Override;

final class InReviewState implements ArticleState
{
    #[Override]
    public function edit(Article $article, string $content): void
    {
        throw new DomainException("Article under review cannot be edited");
    }

    #[Override]
    public function submit(Article $article): void
    {
        throw new DomainException("Article under review cannot be submitted");
    }

    #[Override]
    public function approve(Article $article): void
    {
        $article->transitionTo(new PublishedState());
    }

    #[Override]
    public function reject(Article $article): void
    {
        $article->transitionTo(new RejectedState());
    }

    #[Override]
    public function name(): string
    {
        return 'in_review';
    }
}
