<?php
/**
 * @category    Super Monitoring
 * @package     Siteimpulse_Monitoring
 * @author      SITEIMPULSE
 * @copyright   SITEIMPULSE (https://www.siteimpulse.com/)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Siteimpulse\Monitoring\Block\Adminhtml\System\Config\Fieldset;

use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;

class Hint extends \Magento\Backend\Block\Template implements RendererInterface
{

    /**
     * @var string
     */
    protected $_template = 'Siteimpulse_Monitoring::system/config/fieldset/hint.phtml';
    
    /**
     * Get the value of an inaccessible property.
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return mixed
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return $this->toHtml();
    }
}
