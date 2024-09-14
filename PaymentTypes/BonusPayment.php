<?php

namespace SalaryPaymentTool\PaymentTypes;

use SalaryPaymentTool\Contracts\PaymentTypeInterface;
use SalaryPaymentTool\Services\PaymentDateCalculator;

class BonusPayment implements PaymentTypeInterface
{
    public function __construct(private PaymentDateCalculator $calculator){}

    public function calculatePaymentDate(\DateTime $forDate): \DateTime
    {
        $fifteenth = (clone $forDate)->setDate($forDate->format('Y'), $forDate->format('m'), 15);
        if ($fifteenth->format('N') >= 6) {
            return $this->calculator->getNextWednesdayAfter($fifteenth);
        }
        return $fifteenth;
    }
}