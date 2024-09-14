<?php

namespace SalaryPaymentTool\Contracts;

interface ExporterInterface
{
    public function export(array $data, string $filename): void;
}