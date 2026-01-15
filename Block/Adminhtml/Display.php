<?php
namespace Siteimpulse\Monitoring\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Siteimpulse\Monitoring\Helper\Data;

class Display extends Template
{
    /**
     * @var \Tym17\AdminSample\Helper\ConfigHelper
     */
    protected $_config;

    /**
     * @param Context $context
     * @param Data $config
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Data $config,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_config = $config;
    }

    /**
     * Get the value of an inaccessible property.
     *
     * @return mixed
     */
    public function getDatahelper()
    {
        return $this->_config;
    }
}
