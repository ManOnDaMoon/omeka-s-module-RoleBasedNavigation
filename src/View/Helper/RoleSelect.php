<?php
namespace RoleBasedNavigation\View\Helper;

use Zend\Form\Factory;
use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * View helper for rendering a select menu containing all roles.
 */
class RoleSelect extends AbstractHelper
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $formElementManager;

    /**
     * Construct the helper.
     *
     * @param ServiceLocatorInterface $formElementManager
     */
    public function __construct(ServiceLocatorInterface $formElementManager)
    {
        $this->formElementManager = $formElementManager;
    }

    /**
     * Render a select menu containing all roles.
     *
     * @param array $spec
     * @return string
     */
    public function __invoke(array $spec = [])
    {
        $spec['type'] = 'RoleBasedNavigation\Form\Element\RoleSelect';
        $factory = new Factory($this->formElementManager);
        $element = $factory->createElement($spec);
        return $this->getView()->formSelect($element);
    }
}
