<?php
namespace RoleBasedNavigation\Service\Form\Element;

use Interop\Container\ContainerInterface;
use Zend\Form\Element\Select;
use Zend\ServiceManager\Factory\FactoryInterface;

class RoleSelectFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        $acl = $services->get('Omeka\Acl');
        $userRoles = $acl->getRoleLabels(); // @translate

        $sitePermissions = [
            'permission_viewer' => 'Viewer', // @translate
            'permission_editor' => 'Editor', // @translate
            'permission_admin' => 'Admin', // @translate
        ];

        $roles[] = ['label' => 'User roles', 'options' => $userRoles];
        $roles[] = ['label' => 'Site roles', 'options' => $sitePermissions];

        $element = new Select;
        $element->setValueOptions($roles);
        return $element;
    }
}
