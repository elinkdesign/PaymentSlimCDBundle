<?php

namespace TPM\Payment\SlimCDBundle\Client\Authentication;

use JMS\Payment\CoreBundle\BrowserKit\Request;

class TokenAuthenticationStrategy implements AuthenticationStrategyInterface
{
    protected $clientid;
    protected $endpoint;
    protected $password;
    protected $siteid;
    protected $priceid;
    protected $key;
    protected $usetestaccount;

    public function __construct($clientid, $endpoint, $password, $siteid, $priceid, $key, $usetestaccount)
    {
        $this->clientid = $clientid;
        $this->endpoint = $endpoint;
        $this->password = $password;
        $this->siteid = $siteid;
        $this->priceid = $priceid;
        $this->key = $key;
        $this->usetestaccount = $usetestaccount;
    }

    public function authenticate(Request $request)
    {
        $request->request->set('GW_CLIENTID', $this->clientid);
        $request->request->set('GW_ENDPOINT', $this->endpoint);
        $request->request->set('GW_PASSWORD', $this->password);
        $request->request->set('GW_SITEID', $this->siteid);
        $request->request->set('GW_PRICEID', $this->priceid);
        $request->request->set('GW_KEY', $this->key);
        $request->request->set('USETESTACCOUNT', $this->usetestaccount);
    }
}