<?php

declare(strict_types=1);

namespace Patterns\State\Article;

use Override;

final class InMemoryTransitionLogger implements TransitionLogger
{
    private array $transitions = [];

    #[Override]
    public function record(string $fromState, string $toState): void
    {
        $this->transitions[] = [
            'from' => $fromState,
            'to' => $toState
        ];
    }

    public function transitions()
    {
        return $this->transitions;
    }
}
