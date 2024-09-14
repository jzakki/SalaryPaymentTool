<?php

namespace SalaryPaymentTool\PaymentTypes;

use SalaryPaymentTool\Contracts\PaymentTypeInterface;
use SalaryPaymentTool\Services\PaymentDateCalculator;

class SalaryPayment implements PaymentTypeInterface
{
    public function __construct(private PaymentDateCalculator $calculator){}

    public function calculatePaymentDate(\DateTime $forDate): \DateTime
    {
        return $this->calculator->getLastWorkingDayOfMonth($forDate);
    }
}