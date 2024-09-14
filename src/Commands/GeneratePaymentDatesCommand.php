<?php

namespace SalaryPaymentTool\Commands;

use SalaryPaymentTool\Contracts\CalendarInterface;
use SalaryPaymentTool\Contracts\ExporterInterface;
use SalaryPaymentTool\Contracts\PaymentTypeInterface;

class GeneratePaymentDatesCommand
{
    public function __construct(
        private PaymentTypeInterface $salaryPayment,
        private PaymentTypeInterface $bonusPayment,
        private ExporterInterface $exporter,
        private CalendarInterface $calendar
    ) {}

    public function execute(\DateTimeInterface $startDate, \DateTimeInterface $endDate, string $outputFileName): void
    {
        $currentDate = clone $startDate;
        $data = [['Month', 'Salary Payment Date', 'Bonus Payment Date']];

        while ($currentDate <= $endDate) {
            $month = $currentDate->format('F Y');
            $salaryDate = $this->salaryPayment->calculatePaymentDate($currentDate);
            $bonusDate = $this->bonusPayment->calculatePaymentDate($currentDate);

            $data[] = [
                $month,
                $salaryDate->format('Y-m-d'),
                $bonusDate->format('Y-m-d')
            ];

            $currentDate = $this->calendar->modifyDate($currentDate, 'first day of next month');
        }

        $this->exporter->export($data, $outputFileName);
        echo "Payment dates have been exported to $outputFileName\n";
    }
}