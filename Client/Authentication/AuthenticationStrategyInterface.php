<?php

namespace eLink\Payment\SlimCDBundle\Client\Authentication;

use JMS\Payment\CoreBundle\BrowserKit\Request;

interface AuthenticationStrategyInterface
{
    // function getApiEndpoint();
    function authenticate(Request $request);
}