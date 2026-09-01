<?php

declare(strict_types=1);

namespace Patterns\Factory\Report;

interface ReportExporter
{
    public function export(array $data): string;
}
