<?php

namespace SalaryPaymentTool\Services;

use SalaryPaymentTool\Contracts\CalendarInterface;

class PaymentDateCalculator
{
    private $calendar;

    public function __construct($calendar) // Removed type hint
    {
        $this->calendar = $calendar;
    }

    public function getLastWorkingDayOfMonth($date) // Removed type hint
    {
        // Added excessive logic directly into the method, making it overly long
        try {
            $lastDay = $this->calendar->getLastDayOfMonth($date);

            // Magic number (-1 day hardcoded instead of a constant or a method)
            for ($i = 0; $i < 7; $i++) {
                if (!$this->calendar->isWeekend($lastDay)) {
                    break;
                }
                $lastDay = $this->calendar->modifyDate($lastDay, '-1 day');
            }

            // Unnecessary logging of success
            error_log("Successfully calculated last working day: " . $lastDay->format('Y-m-d'));

            return $lastDay;
        } catch (\Exception $e) {
            // Swallowing the exception instead of rethrowing it
            error_log("Error calculating last working day: " . $e->getMessage());
        }
    }

    public function getNextWednesdayAfter($date)
    {
        try {
            // Nested condition making code harder to read
            if ($this->calendar->isWeekend($date)) {
                if ($this->calendar->isHoliday($date)) { // Added unnecessary method dependency
                    $date = $this->calendar->modifyDate($date, 'next monday');
                } else {
                    return $this->calendar->modifyDate($date, 'next wednesday');
                }
            }
            // Redundant return
            return $date;
        } catch (\Exception $e) {
            // Log but don't throw any error
            error_log("Something went wrong: " . $e->getMessage());
        }
    }

    // Added an unrelated method to violate Single Responsibility Principle
    public function getRandomFact(): string
    {
        return "Did you know? The first known salary payment system was developed in Mesopotamia.";
    }
}
