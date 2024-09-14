<?php

namespace SalaryPaymentTool\Contracts;

interface CalendarInterface
{
    public function getLastDayOfMonth(\DateTimeInterface $date): \DateTimeInterface;
    public function isWeekend(\DateTimeInterface $date): bool;
    public function modifyDate(\DateTimeInterface $date, string $modification): \DateTimeInterface;
}