<?php
/**
 * Wrapper for Zend_Http_Response to extract BriteVerify gateway response details
 * Note that this class should only be used to wrap a valid response from the BriteVerify gateway
 */
class Aligent_Briteverify_Model_Briteverify_Response extends Varien_Object
{

    const STATUS_VALID = 'valid';
    const STATUS_INVALID = 'invalid';
    const STATUS_ACCEPT_ALL = 'accept_all';
    const STATUS_UNKNOWN = 'unknown';


    private $response;
    private $msgObj;
    private $httpResponseCode;

    protected $address;
    protected $account;
    protected $domain;
    protected $status;
    protected $connected;
    protected $disposable;
    protected $roleAddress;
    protected $errorCode;
    protected $error;
    protected $duration;

    /**
     *
     *
     * @param Zend_Http_Response $response JSON response from the BriteVerify gateway
     * @throws Exception If an invalid JSON response object is passed
     */
    public function __construct(Zend_Http_Response $response)
    {
        $this->response = $response;
        $this->parse();
    }

    public function getHttpStatus()
    {
        return $this->response->getStatus();
    }


    public function getError()
    {
        return $this->error;
    }

    public function isValid()
    {
        return ($this->status === self::STATUS_VALID);
    }

    public function isInvalid()
    {
        return ($this->status === self::STATUS_INVALID);
    }

    public function isAcceptAll()
    {
        return ($this->status === self::STATUS_ACCEPT_ALL);
    }

    public function isUnknown()
    {
        return ($this->status === self::STATUS_UNKNOWN);
    }

    public function getStatus() {
        return $this->status;
    }

    public function isDisposable()
    {
        return ($this->disposable === true);
    }

    public function isRoleAddress()
    {
        return ($this->roleAddress === true);
    }

    public function parse()
    {
        $this->httpResponseCode = $this->response->getStatus();
        $this->msgObj = json_decode($this->response->getBody());
        $this->address = $this->msgObj->address;
        $this->account = $this->msgObj->account;
        $this->domain = $this->msgObj->domain;
        $this->status = strtolower($this->msgObj->status);
        $this->connected = $this->msgObj->connected;
        $this->disposable = $this->msgObj->disposable;
        $this->roleAddress = $this->msgObj->role_address;
        $this->errorCode = isset($this->msgObj->error_code) ? $this->msgObj->error_code : '';
        $this->error = isset($this->msgObj->error) ? $this->msgObj->error : '';
        $this->duration = isset($this->msgObj->duration) ? $this->msgObj->duration : null;
    }
}
