<?php

namespace SalaryPaymentTool\Contracts;

interface PaymentTypeInterface
{
    public function calculatePaymentDate(\DateTime $forDate): \DateTime;
}