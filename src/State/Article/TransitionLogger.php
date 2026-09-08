<?php

declare(strict_types=1);

namespace Patterns\State\Article;

interface TransitionLogger
{
    public function record(
        string $fromState,
        string $toState
    ): void;
}
