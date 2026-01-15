<?php
/**
 *
 * @category    Super Monitoring
 * @package     Siteimpulse_Monitoring
 * @author      SITEIMPULSE
 */

namespace Siteimpulse\Monitoring\Model\Config\Backend;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Config\Model\ResourceModel\Config;
use Magento\Framework\App\Config\Value;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\HTTP\Client\Curl;

class Token extends Value
{
    protected Curl $curl;
    protected Config $resourceConfig;
    private DateTime $date;
    private ManagerInterface $messageManager;
    private StoreRepositoryInterface $storeRepository;

    /**
     * Token constructor.
     * 
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param ScopeConfigInterface $config
     * @param TypeListInterface $cacheTypeList
     * @param Config $resourceConfig
     * @param DateTime $date
     * @param StoreRepositoryInterface $storeRepository
     * @param ManagerInterface $messageManager
     * @param Curl $curl
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        Config $resourceConfig,
        DateTime $date,
        StoreRepositoryInterface $storeRepository,
        ManagerInterface $messageManager,
        Curl $curl,
        ?AbstractResource $resource = null,
        ?AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->resourceConfig = $resourceConfig;
        $this->date = $date;
        $this->storeRepository = $storeRepository;
        $this->messageManager = $messageManager;
        $this->curl = $curl;

        // Call parent constructor with Registry
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    /**
     * Perform actions before saving
     */
    public function beforeSave()
    {
        $generalData = $this->getData();
        $valid = $this->getApiResponse($this->getValue());

        if ($valid == '0') {
            $this->messageManager->addErrorMessage(
                __("Invalid token. You can obtain your token in your Account Settings at
                    <a href='https://www.supermonitoring.com' target='_blank'>www.supermonitoring.com</a>.")
            );
        } else {
            $this->messageManager->addSuccessMessage(__("Changes have been saved."));
            return parent::beforeSave();
        }
    }

    /**
     * Get API response
     */
    public function getApiResponse($token)
    {
        $api = 'https://www.supermonitoring.com/API/';
        $string = 'f=wp_token&token=' . $token;
        $this->curl->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->curl->setOption(CURLOPT_POST, true);
        $this->curl->setOption(CURLOPT_POSTFIELDS, $string);
        $this->curl->get($api);
        return $this->curl->getBody();
    }
}