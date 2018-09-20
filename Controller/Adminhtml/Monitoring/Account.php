<?php
/**
 *
 * @category    Super Monitoring
 * @package     Siteimpulse_Monitoring
 * @author      SITEIMPULSE
 * @copyright   SITEIMPULSE (https://www.siteimpulse.com/)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Siteimpulse\Monitoring\Controller\Adminhtml\Monitoring;

use Magento\Backend\App\Action\Context;

class Account extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_PAGE);
        return  $resultPage;
    }
    /**
     * Check Permission.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Siteimpulse_Monitoring::monitoring');
    }
}
