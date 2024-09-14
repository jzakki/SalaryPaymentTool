<?php

namespace SalaryPaymentTool\Services;

class PaymentDateCalculator
{
    public function getLastWorkingDayOfMonth(\DateTime $date): \DateTime
    {
        $lastDay = (clone $date)->modify('last day of this month');
        if ($lastDay->format('N') >= 6) {
            $lastDay->modify('last friday');
        }
        return $lastDay;
    }

    public function getNextWednesdayAfter(\DateTime $date): \DateTime
    {
        return (clone $date)->modify('next wednesday');
    }
}