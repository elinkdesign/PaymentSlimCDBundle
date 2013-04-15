<?php
namespace eLink\Payment\SlimCDBundle\Client;

use Symfony\Component\HttpFoundation\ParameterBag;

class Response
{
    public $body;

    public function __construct(array $parameters)
    {
        $this->body = new ParameterBag($parameters);
    }

    public function __toString()
    {
        if ($this->isError()) {
            $str = 'Debug-Token: '.$this->body->get('CORRELATIONID')."\n";

            foreach ($this->getErrors() as $error) {
                $str .= "{$error['code']}: {$error['short_message']} ({$error['long_message']})\n";
            }
        }
        else {
            $str = var_export($this->body->all(), true);
        }

        return $str;
    }
}