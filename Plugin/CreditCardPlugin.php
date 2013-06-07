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

class CreditCardPlugin extends AbstractPlugin
{
    /**
     * @var \eLink\Payment\SlimCDBundle\Client\Client
     */
    protected $client;

    /**
     * @param string $returnUrl
     * @param string $cancelUrl
     * @param \eLink\Payment\SlimCDBundle\Client\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function checkPaymentInstruction(PaymentInstructionInterface $instruction)
    {
        $errorBuilder = new ErrorBuilder();
        $data = $instruction->getExtendedData();

        // if (!$data->get('ccNumber')) {
        //     $errorBuilder->addDataError('number', 'form.error.required');
        // }

        // if ($instruction->getAmount() > 10000) {
        //     $errorBuilder->addGlobalError('form.error.credit_card_max_limit_exceeded');
        // }

        if ($errorBuilder->hasErrors()) {
            throw $errorBuilder->getException();
        }
    }

    // public function validatePaymentInstruction(PaymentInstructionInterface $instruction)
    // {
        
    // }

    public function approve(FinancialTransactionInterface $transaction, $retry)
    {
        $this->createCheckoutBillingAgreement($transaction, 'AUTH');
    }

    public function approveAndDeposit(FinancialTransactionInterface $transaction, $retry)
    {
        $this->createCheckoutBillingAgreement($transaction, 'SALE');
    }

    public function credit(FinancialTransactionInterface $transaction, $retry)
    {
        $this->createCheckoutBillingAgreement($transaction, 'CREDIT');
    }

    public function deposit(FinancialTransactionInterface $transaction, $retry)
    {
        $this->createCheckoutBillingAgreement($transaction, 'ADD');
    }

    public function processes($method)
    {
        return 'credit_card' === $method;
    }
}