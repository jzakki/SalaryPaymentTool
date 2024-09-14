<?php

namespace SalaryPaymentTool\Contracts;

interface PaymentTypeInterface
{
    public function calculatePaymentDate(\DateTimeInterface $forDate): \DateTimeInterface;
}