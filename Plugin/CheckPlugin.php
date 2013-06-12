<?php

namespace eLink\Payment\SlimCDBundle\Plugin;

use JMS\Payment\CoreBundle\Model\ExtendedDataInterface;
use JMS\Payment\CoreBundle\Model\FinancialTransactionInterface;
use JMS\Payment\CoreBundle\Model\PaymentInstructionInterface;
use JMS\Payment\CoreBundle\Plugin\PluginInterface;
use JMS\Payment\CoreBundle\Plugin\AbstractPlugin;
use JMS\Payment\CoreBundle\Plugin\ErrorBuilder;
use JMS\Payment\CoreBundle\Plugin\Exception\PaymentPendingException;
use JMS\Payment\CoreBundle\Plugin\Exception\FinancialException;
use JMS\Payment\CoreBundle\Plugin\Exception\Action\VisitUrl;
use JMS\Payment\CoreBundle\Plugin\Exception\ActionRequiredException;
use JMS\Payment\CoreBundle\Plugin\Exception\InvalidPaymentInstructionException;
use JMS\Payment\CoreBundle\Util\Number;
use eLink\Payment\SlimCDBundle\Client\Client;
use eLink\Payment\SlimCDBundle\Client\Response;

class CheckPlugin extends AbstractPlugin
{
    public function checkPaymentInstruction(PaymentInstructionInterface $instruction)
    {
        $errorBuilder = new ErrorBuilder();
        $data = $instruction->getExtendedData();

        if (!$data->get('checkNumber')) {
            // $errorBuilder->addDataError('checkNumber', 'form.error.required');
        }

        if ($errorBuilder->hasErrors()) {
            throw $errorBuilder->getException();
        }
    }
    
    public function approveAndDeposit(FinancialTransactionInterface $transaction, $retry)
    {
        $this->createCheckoutBillingAgreement($transaction, 'SALE');
    }

    protected function createCheckoutBillingAgreement(FinancialTransactionInterface $transaction, $paymentAction)
    {
        $data = $transaction->getExtendedData();
        
        $transaction->setResponseCode('Success');
        $transaction->setReasonCode('PaymentActionSuccess');

        $transaction->setResponseCode(PluginInterface::RESPONSE_CODE_SUCCESS);
        $transaction->setReasonCode(PluginInterface::REASON_CODE_SUCCESS);
    }

    public function processes($method)
    {
        return 'check' === $method;
    }
}