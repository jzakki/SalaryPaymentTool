<?php

// bootstrap.php
require_once __DIR__ . '/vendor/autoload.php';

use SalaryPaymentTool\Commands\GeneratePaymentDatesCommand;
use SalaryPaymentTool\Services\PaymentDateCalculator;
use SalaryPaymentTool\PaymentTypes\SalaryPayment;
use SalaryPaymentTool\PaymentTypes\BonusPayment;
use SalaryPaymentTool\Exporters\CsvExporter;

$calculator = new PaymentDateCalculator();
$exporter = new CsvExporter();

$salaryPayment = new SalaryPayment($calculator);
$bonusPayment = new BonusPayment($calculator);

$command = new GeneratePaymentDatesCommand($salaryPayment, $bonusPayment, $exporter);
$command->execute();