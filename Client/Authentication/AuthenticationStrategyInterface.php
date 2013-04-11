<?php

namespace TPM\Payment\SlimCDBundle\Client\Authentication;

use JMS\Payment\CoreBundle\BrowserKit\Request;

interface AuthenticationStrategyInterface
{
    function getApiEndpoint($isDebug);
    function authenticate(Request $request);
}