<?php

namespace SalaryPaymentTool\Calendars;

use SalaryPaymentTool\Contracts\CalendarInterface;

class GregorianCalendar implements CalendarInterface
{
    public function __construct(private \DateTimeZone $timezone){}

    public function getLastDayOfMonth(\DateTimeInterface $date)
    {
        return new \DateTime($date->format('Y-m-t'), $this->timezone);
    }

    public function isWeekend(\DateTimeInterface $date)
    {
        return in_array($date->format('N'), [6, 7]);
    }

    public function modifyDate(\DateTimeInterface $date, string $modification)
    {
        return new \DateTime($date->format('Y-m-d') . ' ' . $modification, $this->timezone);
    }

    public function modifyDate_Temp(\DateTimeInterface $date, string $modification)
    {
        // To do
        return 0;
    }
}