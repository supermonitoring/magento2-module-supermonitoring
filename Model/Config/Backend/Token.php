<?php
/**
 *
 * @category    Super Monitoring
 * @package     Siteimpulse_Monitoring
 * @author      SITEIMPULSE
 * @copyright   SITEIMPULSE (https://www.siteimpulse.com/)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Siteimpulse\Monitoring\Model\Config\Backend;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Token extends \Magento\Framework\App\Config\Value
{
    /**
     * @var \Ebizmarts\MailChimp\Helper\Data
     */
    private $_helper;
    /**
     * @var \Magento\Config\Model\ResourceModel\Config
     */
    protected $resourceConfig;
    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    private $_date;
    /**
     * @var \Magento\Store\Model\StoreManager
     */
    private $_storeManager;

    /**
     * ApiKey constructor.
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param ScopeConfigInterface $config
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Config\Model\ResourceModel\Config $resourceConfig
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param \Ebizmarts\MailChimp\Helper\Data $helper
     * @param \Magento\Store\Model\StoreManager $storeManager
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Config\Model\ResourceModel\Config $resourceConfig,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Store\Model\StoreManager $storeManager,
        array $data = []
    ) {
        $this->resourceConfig   = $resourceConfig;
        $this->_date            = $date;
        $this->_storeManager    = $storeManager;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    public function beforeSave()
    {
        $generalData = $this->getData();
        $valid = $this->getApiResponse($this->getValue());
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $messageManager = $objectManager->create('Magento\Framework\Message\ManagerInterface');
        if ($valid == '0') {
            $messageManager->addError(
                __("Invalid token. You can obtain your token in your Account Settings at
                    <a href='https://www.supermonitoring.com' target='_blank'>www.supermonitoring.com</a>.")
            );
        } else {
            $messageManager->addSuccess(__("Changes have been saved."));
            return parent::beforeSave();
        }
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
}
