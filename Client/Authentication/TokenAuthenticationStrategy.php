<?php

namespace eLink\Payment\SlimCDBundle\Client\Authentication;

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

    public function __construct($args)
    {
        $this->clientid = $args['clientid'];
        $this->endpoint = $args['endpoint'];
        $this->password = $args['password'];
        $this->siteid = $args['siteid'];
        $this->priceid = $args['priceid'];
        $this->key = $args['key'];
        $this->usetestaccount = $args['usetestaccount'];
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