<?php

declare(strict_types=1);

namespace Patterns\Factory\Report;

use Override;

final class CsvReportExporter implements ReportExporter
{
    #[Override]
    public function export(array $data): string
    {
        if (empty($data)) {
            return "";
        }

        $stream = fopen('php://memory', 'r+');

        $firstRow = reset($data);
        $headers = array_keys($firstRow);
        fputcsv($stream, $headers);

        foreach ($data as $row) {
            fputcsv($stream, $row);
        }

        rewind($stream);
        $csvString = stream_get_contents($stream);
        fclose($stream);

        return $csvString;
    }
}
