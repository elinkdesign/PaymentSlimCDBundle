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
        $request->request->set('username', $this->clientid);
        $request->request->set('clientid', $this->clientid);
        $request->request->set('password', $this->password);
        $request->request->set('siteid', $this->siteid);
        $request->request->set('priceid', $this->priceid);
        $request->request->set('key', $this->key);
    }

    public function getApiEndpoint($isDebug)
    {
        return $this->endpoint;
    }
}