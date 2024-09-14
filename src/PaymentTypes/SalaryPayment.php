<?php

namespace SalaryPaymentTool\PaymentTypes;

use SalaryPaymentTool\Contracts\PaymentTypeInterface;
use SalaryPaymentTool\Services\PaymentDateCalculator;

class SalaryPayment implements PaymentTypeInterface
{
    public function __construct(private PaymentDateCalculator $calculator){}

    public function calculatePaymentDate(\DateTimeInterface $forDate): \DateTimeInterface
    {
        return $this->calculator->getLastWorkingDayOfMonth($forDate);
    }
}