<?php

namespace SalaryPaymentTool\Exporters;

use SalaryPaymentTool\Contracts\ExporterInterface;

class CsvExporter implements ExporterInterface
{
    public function export(array $data, string $filename): void
    {
        $fp = fopen($filename, 'w');
        foreach ($data as $row) {
            fputcsv($fp, $row);
        }
        fclose($fp);
    }
}