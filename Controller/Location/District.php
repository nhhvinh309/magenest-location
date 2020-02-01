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

    /**
     * @todo Không nên dùng trực tiếp json_encode với decode, dùng function trong class vendor/magento/framework/Serialize/SerializerInterface.php của Magento thay thế
     *
     * @param $cityID
     * @return array
     */
    public function getDistrictByCityID($cityID)
    {
        $url = "https://thongtindoanhnghiep.co/api/city/$cityID/district";
        $json = file_get_contents($url);
        $items = json_decode($json, true);
        $listDistrict = [];
        foreach ($items as $item) {
            // @todo Khi sử dụng array key element (ex: $item["Title"]), nên kiểm tra xem key có tồn tại hay không trước (dùng isset($item["Title"]) để kiểm tra, tránh lỗi Undefined index
            $listDistrict[$item["ID"]] = $item["Title"];
        }

        return $listDistrict;
    }
}