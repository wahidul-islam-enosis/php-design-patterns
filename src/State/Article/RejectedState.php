<?php

declare(strict_types=1);

namespace Patterns\State\Article;

use DomainException;
use Override;

final class RejectedState implements ArticleState
{
    #[Override]
    public function edit(Article $article, string $content): void
    {
        $article->updateContent($content);
        $article->transitionTo(new DraftState());
    }

    #[Override]
    public function submit(Article $article): void
    {
        throw new DomainException("Rejected article cannot be submitted");
    }

    #[Override]
    public function approve(Article $article): void
    {
        throw new DomainException("Rejected article cannot be approved");
    }

    #[Override]
    public function reject(Article $article): void
    {
        throw new DomainException("Rejected article cannot be rejected");
    }

    #[Override]
    public function name(): string
    {
        return 'rejected';
    }
}
