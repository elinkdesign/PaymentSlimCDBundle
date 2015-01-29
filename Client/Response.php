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

    public function isSuccess()
    {
        return 'success' == strtolower($this->body->get('response'));
    }

    public function isError()
    {
	    return 'fail' == strtolower($this->body->get('response'));
    }

	public function getData($k, $default = NULL) {
		$datablock = $this->body->get('datablock');

		if (!$datablock || !isset($datablock[$k])) {
			return $default;
		}

		return $datablock[$k];
	}

    public function getErrorMessage()
    {
	    return $this->translateErrorMessages($this->body->get('description'));
    }

    public function __toString()
    {
        return var_export($this->body->all(), true);
    }

	public function translateErrorMessages($description) {
		// Example: *--NEED_EXPMONTH--NEED_EXPYEAR--NEED_CARDNUMBER.
		$translated = '';

		if ($this->_descriptionContains($description, 'NEED_CARDNUMBER')) {
			$translated .= 'Your card number was not entered.';
		}

		if ($this->_descriptionContains($description, array('NEED_EXPMONTH', 'NEED_EXPYEAR'))) {
			$translated .= "Your card expiration month and year were not provided.\n";
		} else if ($this->_descriptionContains($description, array('MOD10_FAILED_OR_CARDEXPIRED'))) {
			$translated .= "An incorrect card number or expiration date was provided.\n";
		}

		if ($this->_descriptionContains($description, 'CVV')) {
			$translated .= 'Your CVV code was entered incorrectly.';
		}

		if ($this->_descriptionContains($description, 'DUPLICATE')) {
			$translated .= 'Your payment already went through. Will not submit a duplicate charge.';
		}

		if (empty($translated)) {
			$translated = 'Your payment could not be processed. Please try again.';
		}

		return $translated;
	}

	protected function _descriptionContains($description, $needle)
	{
		if (is_array($needle)) {
			foreach ($needle as $_needle) {
				if ($this->_descriptionContains($description, $_needle)) {
					return true;
				}
			}

			return false;
		}

		return stripos($description, $needle) !== false;
	}
}