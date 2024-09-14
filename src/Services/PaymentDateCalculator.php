<?php

namespace SalaryPaymentTool\Services;

use SalaryPaymentTool\Contracts\CalendarInterface;
use SalaryPaymentTool\Exceptions\PaymentCalculationException;

class PaymentDateCalculator
{
    public function __construct(private CalendarInterface $calendar){}

    public function getLastWorkingDayOfMonth(\DateTimeInterface $date): \DateTimeInterface
    {
        try {
            $lastDay = $this->calendar->getLastDayOfMonth($date);
            while ($this->calendar->isWeekend($lastDay)) {
                $lastDay = $this->calendar->modifyDate($lastDay, '-1 day');
            }
            return $lastDay;
        }
        catch (\Exception $e) {
            error_log("Unexpected error in getLastWorkingDayOfMonth: " . $e->getMessage());
            throw new PaymentCalculationException(
                "Failed to calculate last working day of month",
                0,
                $e
            );
        }
    }

    public function getNextWednesdayAfter(\DateTimeInterface $date): \DateTimeInterface
    {
        try {
            if ($this->calendar->isWeekend($date)) {
                return $this->calendar->modifyDate($date, 'next wednesday');
            }
            return $date;
        }
        catch (\Exception $e) {
            error_log("Unexpected error in getNextWednesdayAfter: " . $e->getMessage());
            throw new PaymentCalculationException(
                "Failed to calculate next wednesday after",
                0,
                $e
            );
        }
    }
}