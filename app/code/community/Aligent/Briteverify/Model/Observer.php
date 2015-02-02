<?php
/**
 * Aligent_Briteverify_Model_Observer
 *
 * @category  Aligent
 * @package   Aligent_Briteverify
 * @author    Andrew Dwyer <andrew@aligent.com.au>
 * @copyright 2015 Aligent Consulting.
 * @link      http://www.aligent.com.au/
 */
class Aligent_Briteverify_Model_Observer {

    /**
     * Observes the controller_action_predispatch_newsletter_subscriber_new event to validate the subscribers
     * email address and fails the subscription if BriteVerify returns an invalid response.
     * @param $observer
     * @return $this
     * @throws Exception
     * @throws Zend_Validate_Exception
     */
    public function newsletterSubscribePredispatch($observer)
    {
        if (!$this->isValidateNewsletterSub()) {
            return $this;
        }

        $errorMsg = 'Please enter a valid email address.';
        $request = $observer->getControllerAction()->getRequest();
        $email = (string) $request->getPost('email');

        // Validate email through Magento first
        if(!Zend_Validate::is($email, 'EmailAddress')) {
            $this->redirectInvalid($request, $errorMsg);
        }

        $briteVerify = Mage::getModel('aligent_briteverify/briteverify');
        // Validate email via BriteVerify
        $res = $briteVerify->validate($email);
        if ($res->isInvalid()) {
            $this->redirectInvalid($request, $errorMsg);
        }
        return $this;
    }

    protected function redirectInvalid($request, $errorMsg) {
        $session = Mage::getSingleton('core/session');
        $session->$errorMsg();
        $request->initForward()
            ->setControllerName('verify')
            ->setModuleName('verify')
            ->setActionName('invalid')
            ->setDispatched(false);
    }

    public function isValidateNewsletterSub() {
        return (Mage::getStoreConfigFlag('aligent_briteverify/aligent_briteverify/enabled') &&
            Mage::getStoreConfigFlag('aligent_briteverify/aligent_briteverify/validate_newsletter_sub'));
    }
}