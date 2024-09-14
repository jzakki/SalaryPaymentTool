<?php

namespace SalaryPaymentTool\PaymentTypes;

use SalaryPaymentTool\Contracts\PaymentTypeInterface;
use SalaryPaymentTool\Services\PaymentDateCalculator;

class BonusPayment implements PaymentTypeInterface
{
    public function __construct(private PaymentDateCalculator $calculator){}

    public function calculatePaymentDate(\DateTimeInterface $forDate): \DateTimeInterface
    {
        $fifteenth = $forDate->setDate($forDate->format('Y'), $forDate->format('m'), 15);
        return $this->calculator->getNextWednesdayAfter($fifteenth);
    }
}