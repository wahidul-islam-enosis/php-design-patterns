<?php

declare(strict_types=1);

namespace Patterns\State\Article;

final class Article
{
    private ArticleState $state;

    public function __construct(
        public string $content
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
        $this->state = $state;
    }

    public function __toString(): string
    {
        return $this->content . PHP_EOL;
    }
}
