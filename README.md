# Magento BriteVerify

A simple module to validate email addresses using the BriteVerify API.

```
$briteVerify = Mage::getModel('aligent_briteverify/briteverify');
$res = $briteVerify->validate('invalid@email.com');
if($res->isAcceptAll() || $res->isValid()) {
    echo "valid";
} else {
    echo $res->getError();
}
```