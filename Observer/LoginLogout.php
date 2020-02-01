<?php
namespace Magenest\Location\Observer;

class LoginLogout implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        // @todo Viết lại class sử dụng cho get set Cookie, có thể dùng class Model hoặc Helper, controller chỉ nên xử lý action, không dùng cho reference ở những class khác
        // tham khảo vendor/magento/module-theme/Controller/Result/MessagePlugin.php
        $objectManager->get('Magenest\Location\Controller\Location\Save')->setLocationCookie(json_encode(""));
    }
}