<?php

namespace Magenest\Location\Controller\Location;

class Ward extends \Magento\Framework\App\Action\Action
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
        $frameName = $this->getRequest()->getParam('ward');
        if($frameName != "")
        {
            $listWard = $this->getWardByDistrictID($frameName);
            foreach ($listWard as $key => $value)
            {
                $html .= '<option value="'.$key.'">'.$value.'</option>';
            }
        }
        return $result->setData(['success' => true, 'value' => $html]);
    }
    public function getWardByDistrictID($districtID){
        $url = "https://thongtindoanhnghiep.co/api/district/$districtID/ward";
        $json = file_get_contents($url);
        $items = json_decode($json, true);
        $listWard =[];
        foreach ($items as $item)
        {
            $listWard[$item["ID"]] = $item["Title"];
        }

        return $listWard;
    }
}