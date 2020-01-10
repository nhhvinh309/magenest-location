<?php

namespace Magenest\Location\Controller\Location;

class District extends \Magento\Framework\App\Action\Action
{
    protected $resultJsonFactory;

    protected $regionColFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Directory\Model\RegionFactory $regionColFactory)
    {
        $this->regionColFactory = $regionColFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $html = '<option selected="selected" value="">Please Select Option</option>';
        $frameName = $this->getRequest()->getParam('district');
        if($frameName != "")
        {
            $listDistrict = $this->getDistrictByCityID($frameName);
            foreach ($listDistrict as $key => $value)
            {
                $html .= '<option value="'.$key.'">'.$value.'</option>';
            }
        }
        return $result->setData(['success' => true, 'value' => $html]);
    }

    public function getDistrictByCityID($cityID)
    {
        $url = "https://thongtindoanhnghiep.co/api/city/$cityID/district";
        $json = file_get_contents($url);
        $items = json_decode($json, true);
        $listDistrict = [];
        foreach ($items as $item) {
            $listDistrict[$item["ID"]] = $item["Title"];
        }

        return $listDistrict;
    }
}