<?php
namespace Magenest\Location\Observer;

class LoginLogout implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $objectManager->get('Magenest\Location\Controller\Location\Save')->setLocationCookie(json_encode(""));
    }
}