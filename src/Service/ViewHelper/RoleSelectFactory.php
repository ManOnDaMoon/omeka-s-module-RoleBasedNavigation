<?php

namespace RoleBasedNavigation\Service\ViewHelper;

use RoleBasedNavigation\View\Helper\RoleSelect;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class RoleSelectFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        return new RoleSelect($services->get('FormElementManager'));
    }
}
