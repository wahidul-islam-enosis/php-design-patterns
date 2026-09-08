<?php

declare(strict_types=1);

namespace Patterns\State\Article;

final class Article
{
    private ArticleState $state;

    public function __construct(
        private string $content,
        private TransitionLogger $logger
    ) {
        $this->state = new DraftState();
    }

    public function edit(string $content): void
    {
        $this->state->edit($this, $content);
    }

    public function submit(): void
    {
        $this->state->submit($this);
    }

    public function approve(): void
    {
        $this->state->approve($this);
    }

    public function reject(): void
    {
        $this->state->reject($this);
    }

    public function status(): string
    {
        return $this->state->name();
    }

    public function transitionTo(ArticleState $state): void
    {
        $fromState = $this->state->name();
        $this->state = $state;
        $toState = $state->name();
        $this->logger->record(
            fromState: $fromState,
            toState: $toState
        );
    }

    public function updateContent(string $content): void
    {
        $this->content = $content;
    }

    public function __toString(): string
    {
        return $this->content . PHP_EOL;
    }
}
