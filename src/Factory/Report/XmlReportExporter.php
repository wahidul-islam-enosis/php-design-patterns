<?php

declare(strict_types=1);

namespace Patterns\Factory\Report;

use InvalidArgumentException;
use Override;
use SimpleXMLElement;

final class XmlReportExporter implements ReportExporter
{
    public function __construct(
        private readonly string $rootElement = 'report'
    ) {
        if (!preg_match('/^[A-Za-z_][A-Za-z0-9_.-]*$/', $rootElement)) {
            throw new InvalidArgumentException('Invalid XML root element.');
        }
    }

    #[Override]
    public function export(array $data): string
    {
        $xml = new SimpleXMLElement('<' . $this->rootElement . '/>');

        $arrayToXmlBuilder = function (array $data, SimpleXMLElement &$xml) use (&$arrayToXmlBuilder) {
            foreach ($data as $key => $val) {
                if (is_numeric($key)) {
                    $key = 'item' . $key;
                }
                if (is_array($val)) {
                    $child = $xml->addChild($key);
                    $arrayToXmlBuilder($val, $child);
                } else {
                    $xml->addChild($key, is_bool($val) ? ($val ? 'true' : 'false') : htmlspecialchars((string) $val));
                }
            }
        };

        $arrayToXmlBuilder($data, $xml);

        return $xml->asXML();
    }
}
