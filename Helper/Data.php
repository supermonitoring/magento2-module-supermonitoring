<?php
/**
 *
 * @category    Super Monitoring
 * @package     Siteimpulse_Monitoring
 * @author      SITEIMPULSE
 * @copyright   SITEIMPULSE (https://www.siteimpulse.com/)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Siteimpulse\Monitoring\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const ACTIVE_MODULE = "monitoring/general/active";
    const AUTH_TOKEN = "monitoring/general/token";
    const DEFAULT_URL = "https://www.supermonitoring.com/index.php";
    const ES_URL = "https://www.supermonitoring.es/index.php";
    const DE_URL = "https://www.supermonitoring.de/index.php";
    const PL_URL = "https://www.supermonitoring.pl/index.php";

    protected $scopeConfig;
    protected $_store;
    protected $authSession;
    
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Store\Api\Data\StoreInterface $store
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->_store = $store;
        $this->authSession = $authSession;
    }
    public function getApiResponse($token)
    {
        $api = 'https://www.supermonitoring.com/API/';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        $string = 'f=wp_token&token=' . $token;
        curl_setopt($curl, CURLOPT_POSTFIELDS, $string);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    public function active()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::ACTIVE_MODULE);
    }

    public function getAuthorizationToken()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::AUTH_TOKEN);
    }

    public function checkTokenIsValid()
    {
        $isValid = $this->getApiResponse($this->getAuthorizationToken());
        if ($isValid == '0') {
            return false;
        }

        return true;
    }

    public function getIframeUrl($page = null)
    {
        $url = $this->getURL()."?wp_token=".$this->getAuthorizationToken()."&cms=magento2";
        if ($page) {
            $url.= "&s=".$page;
        }

        return $url;
    }
    public function getUserLanguage()
    {
        return  $this->authSession->getUser()->getInterfaceLocale();
    }

    public function getURL()
    {
        $language = $this->getUserLanguage();
        switch ($language) {
            case "de_DE":
                return self::DE_URL;
                break;
            case "de_LU":
                return self::DE_URL;
                break;
            case "de_CH":
                return self::DE_URL;
                break;
            case "de_AT":
                return self::DE_URL;
                break;
            case "es_AR":
                return self::ES_URL;
                break;
            case "es_ES":
                return self::ES_URL;
                break;
            case "es_BO":
                return self::ES_URL;
                break;
            case "es_CL":
                return self::ES_URL;
                break;
            case "es_CO":
                return self::ES_URL;
                break;
            case "es_CR":
                return self::ES_URL;
                break;
            case "es_MX":
                return self::ES_URL;
                break;
            case "es_PA":
                return self::ES_URL;
                break;
            case "es_PE":
                return self::ES_URL;
                break;
            case "es_VE":
                return self::ES_URL;
                break;

            case "pl_PL":
                return self::PL_URL;
                break;
            default:
                return self::DEFAULT_URL;
        }
    }
}
