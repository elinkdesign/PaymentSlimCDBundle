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
use JMS\Payment\CoreBundle\Plugin\Exception\CommunicationException;
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

        if (!$data->get('token') && !$data->get('ccNumber')) {
            $errorBuilder->addGlobalError('Your payment could not be processed using the details entered. Please try again.');
        }

        if ($errorBuilder->hasErrors()) {
            throw $errorBuilder->getException();
        }
    }
    
    protected function createCheckoutBillingAgreement(FinancialTransactionInterface $transaction, $paymentAction)
    {
        $data = $transaction->getExtendedData();
        $success = $message = false;

        try {
	        $api_params = $data->has('api_params') ? $data->get('api_params') : array();

            $response = $this->client->sendApiRequest(array(
                'transtype' => $paymentAction,
                'amount' => $transaction->getRequestedAmount(),
                'temporary_token' => $data->get('token'),
            ) + $api_params);

	        if (!($success = $response->isSuccess())) {
		        $message = $response->getErrorMessage();
	        }
        } catch (CommunicationException $e) {
            $message = "Failed to process your payment. Please try again.";
        }

        if (!$success) {
            $ex = new FinancialException($message);
            $ex->setFinancialTransaction($transaction);
            $transaction->setResponseCode('Failed');
            $transaction->setReasonCode(PluginInterface::REASON_CODE_INVALID);
            throw $ex;
        }

        $transaction->setResponseCode(PluginInterface::RESPONSE_CODE_SUCCESS);
        $transaction->setReasonCode(PluginInterface::REASON_CODE_SUCCESS);

	    $ticket_number = $response->getData('gateid');
	    $data->set('ticket_number', $ticket_number, false);
    }

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
