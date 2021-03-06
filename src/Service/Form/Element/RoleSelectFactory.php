<?php
namespace RoleBasedNavigation\Service\Form\Element;

use Interop\Container\ContainerInterface;
use RoleBasedNavigation\Module;
use Laminas\Form\Element\Select;
use Laminas\ServiceManager\Factory\FactoryInterface;

class RoleSelectFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        $acl = $services->get('Omeka\Acl');
        $userRoles = $acl->getRoleLabels();

        $sitePermissions = [
            'permission_viewer' => 'Viewer', // @translate
            'permission_editor' => 'Creator', // @translate
            'permission_admin' => 'Manager', // @translate
        ];

        $genericRoles = [
            Module::RBN_AUTHENTICATED_USERS => 'Authenticated users only', // @translate
            Module::RBN_UNAUTHENTICATED_VISITORS => 'Unregistered visitors only', // @translate
        ];

        $roles[] = [
            'label' => 'Global filters — will override single role filters', // @translate
            'options' => $genericRoles,

        ];

        $roles[] = [
            'label' => 'User roles', // @translate
            'options' => $userRoles

        ];
        $roles[] = [
            'label' => 'Site roles', // @translate
            'options' => $sitePermissions

        ];

        $element = new Select;
        $element->setValueOptions($roles);
        return $element;
    }
}
