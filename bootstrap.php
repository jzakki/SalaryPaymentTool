<?php

require_once __DIR__ . '/vendor/autoload.php';

use SalaryPaymentTool\Commands\GeneratePaymentDatesCommand;
use SalaryPaymentTool\Services\PaymentDateCalculator;
use SalaryPaymentTool\PaymentTypes\SalaryPayment;
use SalaryPaymentTool\PaymentTypes\BonusPayment;
use SalaryPaymentTool\Exporters\CsvExporter;
use SalaryPaymentTool\Calendars\GregorianCalendar;

// Parse command-line arguments
$options = getopt("", ["output:"]);

if (!isset($options['output'])) {
    echo "Usage: php bootstrap.php --output=<filename>\n";
    exit(1);
}

$outputFileName = $options['output'];

// Set up the timezone (this could be configurable)
$timezone = new DateTimeZone('Europe/Berlin');

// Set up the calendar
$calendar = new GregorianCalendar($timezone);

// Set up the calculator with the calendar
$calculator = new PaymentDateCalculator($calendar);

$exporter = new CsvExporter();

$salaryPayment = new SalaryPayment($calculator);
$bonusPayment = new BonusPayment($calculator);

$command = new GeneratePaymentDatesCommand($salaryPayment, $bonusPayment, $exporter, $calendar);

// Set start and end dates (could be configurable)
$startDate = new DateTime('first day of this month', $timezone);
$endDate = new DateTime('last day of december', $timezone);

$command->execute($startDate, $endDate, $outputFileName);
