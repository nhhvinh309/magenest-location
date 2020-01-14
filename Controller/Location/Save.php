<?php

namespace Magenest\Location\Controller\Location;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;
use Magento\Framework\Session\SessionManagerInterface;

class Save extends \Magento\Framework\App\Action\Action
{


    const COOKIE_NAME = 'location';
    private $cookieManager;
    private $cookieMetadataFactory;
    private $sessionManager;
    protected $resultJsonFactory;

    public function __construct(Context $context,
                                CookieManagerInterface $cookieManager,
                                CookieMetadataFactory $cookieMetadataFactory,
                                SessionManagerInterface $sessionManager,
                                \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory)
    {
        $this->cookieManager = $cookieManager;
        $this->cookieMetadataFactory = $cookieMetadataFactory;
        $this->sessionManager = $sessionManager;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $param = $this->getRequest()->getParams();
        $html = '<div class="your-location" style="display: inline-block"> Your location : ' . $param["city"] . '  ' . $param["district"] . '  ' . $param["ward"] . ' </div>';
        $this->setLocationCookie(json_encode($param));
        return $result->setData(['success' => true, 'value' => $html]);
    }

    public function getLocationCookie()
    {
        return $this->cookieManager->getCookie(self::COOKIE_NAME);
    }

    public function setLocationCookie($value)
    {
        $duration = 86400;
        $metadata = $this->cookieMetadataFactory
            ->createPublicCookieMetadata()
            ->setDuration($duration)
            ->setPath($this->sessionManager->getCookiePath())
            ->setDomain($this->sessionManager->getCookieDomain());

        $this->cookieManager->setPublicCookie(
            self::COOKIE_NAME,
            $value,
            $metadata
        );
    }
}