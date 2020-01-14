<?php

namespace Magenest\Location\Block;

use Magento\Framework\View\Element\Template;

class Location extends Template
{
    protected $storeManager;
    public function __construct(Template\Context $context, array $data = [],\Magento\Store\Model\StoreManagerInterface $storeManager)
    {
        parent::__construct($context, $data);
        $this->storeManager= $storeManager;
    }
    public function getListCity(){
        $url = "https://thongtindoanhnghiep.co/api/city";
        $json = file_get_contents($url);
        $obj = json_decode($json, true);
        $listItem = $obj["LtsItem"];
        $listCity =[];
        foreach ($listItem as $item)
        {
            $listCity[$item["ID"]] = $item["Title"];
        }

        return $listCity;
    }
    public function getCookieData(){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $data = $objectManager->get('Magenest\Location\Controller\Location\Save')->getLocationCookie();
        return json_decode($data, true);
    }
    public function getBaseUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl();
    }
}