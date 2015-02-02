<?php

/**
 * Aligent_Briteverify_VerifyController
 *
 * @category  Aligent
 * @package   Aligent_Briteverify
 * @author    Andrew Dwyer <andrew@aligent.com.au>
 * @copyright 2015 Aligent Consulting.
 * @link      http://www.aligent.com.au/
 */
class Aligent_Briteverify_VerifyController extends Mage_Core_Controller_Front_Action {

    /**
     * Redirects the customer to the previous page to display the session error message
     */
    public function invalidAction() {
        $this->_redirectReferer();
    }
}