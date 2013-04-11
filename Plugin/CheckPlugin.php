<?php

namespace TPM\Payment\SlimCDBundle\Plugin;

use JMS\Payment\CoreBundle\Model\ExtendedDataInterface;
use JMS\Payment\CoreBundle\Model\FinancialTransactionInterface;
use JMS\Payment\CoreBundle\Plugin\PluginInterface;
use JMS\Payment\CoreBundle\Plugin\AbstractPlugin;
use JMS\Payment\CoreBundle\Plugin\Exception\PaymentPendingException;
use JMS\Payment\CoreBundle\Plugin\Exception\FinancialException;
use JMS\Payment\CoreBundle\Plugin\Exception\Action\VisitUrl;
use JMS\Payment\CoreBundle\Plugin\Exception\ActionRequiredException;
use JMS\Payment\CoreBundle\Util\Number;
use TPM\Payment\SlimCDBundle\Client\Client;
use TPM\Payment\SlimCDBundle\Client\Response;

class CheckPlugin extends AbstractPlugin
{
    public function checkPaymentInstruction(PaymentInstructionInterface $instruction)
    {
        $errorBuilder = new ErrorBuilder();
        $data = $instruction->getExtendedData();

        if ($errorBuilder->hasErrors()) {
            throw $errorBuilder->getException();
        }
    }

    public function processes($method)
    {
        return 'slimcd_check' === $method;
    }
}