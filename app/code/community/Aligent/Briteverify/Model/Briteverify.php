<?php

/**
 * Aligent_Briteverify_Model_Briteverify
 *
 * @category  Aligent
 * @package   Aligent_Briteverify
 * @author    Andrew Dwyer <andrew@aligent.com.au>
 * @copyright 2015 Aligent Consulting.
 * @link      http://www.aligent.com.au/
 */
class Aligent_Briteverify_Model_Briteverify {

    const VERIFY_URL = "https://bpi.briteverify.com/emails.json";

    const MAX_REDIRECTS = 1;
    const TIMEOUT = 20;

    public function validate($email) {
        if($this->isEnabled()) {
            $client = new Zend_Http_Client();
            $client->setConfig($this->getHttpConfig());
            $client->setMethod($client::GET);
            $client->setParameterGet('address', $email);
            $client->setParameterGet('apikey', Mage::getStoreConfig('aligent_briteverify/aligent_briteverify/apikey'));
            $client->setUri(self::VERIFY_URL);
            $responseReader = Mage::getModel("aligent_briteverify/briteverify_response", $client->request());
            return $responseReader;
        }
    }

    public function isEnabled() {
        return Mage::getStoreConfigFlag('aligent_briteverify/aligent_briteverify/enabled');
    }

    private function getHttpConfig()
    {
        return array(
            'maxredirects' => self::MAX_REDIRECTS,
            'timeout' => self::TIMEOUT,
        );
    }


}