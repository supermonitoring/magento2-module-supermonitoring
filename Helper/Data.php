<?php
namespace Siteimpulse\Monitoring\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Backend\Model\Auth\Session;
use Magento\Store\Api\Data\StoreInterface;

class Data
{
    private const ACTIVE_MODULE = "monitoring/general/active";
    private const AUTH_TOKEN = "monitoring/general/token";
    private const DEFAULT_URL = "https://www.supermonitoring.com/index.php";
    private const ES_URL = "https://www.supermonitoring.es/index.php";
    private const DE_URL = "https://www.supermonitoring.de/index.php";
    private const PL_URL = "https://www.supermonitoring.pl/index.php";

    protected $curl;
    protected $scopeConfig;
    protected $authSession;
    protected $_store;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Session $authSession,
        Curl $curl,
        StoreInterface $store
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->_store = $store;
        $this->authSession = $authSession;
        $this->curl = $curl;
    }

    public function getApiResponse($token)
    {
        $api = 'https://www.supermonitoring.com/API/';
        $string = 'f=wp_token&token=' . $token;

        $this->curl->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->curl->setOption(CURLOPT_POST, true);
        $this->curl->setOption(CURLOPT_POSTFIELDS, $string);
        
        $response = $this->curl->post($api, $string);
        return $response;
    }

    public function active()
    {
        return $this->scopeConfig->getValue(self::ACTIVE_MODULE, ScopeInterface::SCOPE_STORE);
    }

    public function getAuthorizationToken()
    {
        return $this->scopeConfig->getValue(self::AUTH_TOKEN, ScopeInterface::SCOPE_STORE);
    }

    public function checkTokenIsValid()
    {
        $isValid = $this->getApiResponse($this->getAuthorizationToken());
        return $isValid == '0' ? false : true;
    }

    public function getIframeUrl($page = null)
    {
        $url = $this->getURL()."?wp_token=".$this->getAuthorizationToken()."&cms=magento2";
        if ($page) {
            $url .= "&s=".$page;
        }

        return $url;
    }

    public function getUserLanguage()
    {
        return $this->authSession->getUser()->getInterfaceLocale();
    }

    public function getURL()
    {
        $language = $this->getUserLanguage();
        switch ($language) {
            case "de_DE":
            case "de_LU":
            case "de_CH":
            case "de_AT":
                return self::DE_URL;
            case "es_AR":
            case "es_ES":
            case "es_BO":
            case "es_CL":
            case "es_CO":
            case "es_CR":
            case "es_MX":
            case "es_PA":
            case "es_PE":
            case "es_VE":
                return self::ES_URL;
            case "pl_PL":
                return self::PL_URL;
            default:
                return self::DEFAULT_URL;
        }
    }
}
