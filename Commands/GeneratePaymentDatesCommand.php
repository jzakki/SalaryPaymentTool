<?php

namespace SalaryPaymentTool\Commands;

use SalaryPaymentTool\Contracts\ExporterInterface;
use SalaryPaymentTool\Contracts\PaymentTypeInterface;

class GeneratePaymentDatesCommand
{
    public function __construct(
        private PaymentTypeInterface $salaryPayment,
        private PaymentTypeInterface $bonusPayment,
        private ExporterInterface $exporter
    ) {}

    public function execute(): void
    {
        $currentDate = new \DateTime();
        $endDate = (new \DateTime())->modify('last day of december');
        $data = [['Month', 'Salary Payment Date', 'Bonus Payment Date']];

        while ($currentDate <= $endDate) {
            $month = $currentDate->format('F');
            $salaryDate = $this->salaryPayment->calculatePaymentDate($currentDate);
            $bonusDate = $this->bonusPayment->calculatePaymentDate($currentDate);

            $data[] = [
                $month,
                $salaryDate->format('Y-m-d'),
                $bonusDate->format('Y-m-d')
            ];

            $currentDate->modify('first day of next month');
        }

        $this->exporter->export($data, 'payment_dates.csv');
        echo "Payment dates have been exported to payment_dates.csv\n";
    }
}