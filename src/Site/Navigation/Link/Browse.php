<?php
namespace RoleBasedNavigation\Site\Navigation\Link;

class Browse extends \Omeka\Site\Navigation\Link\Browse
{

    public function getFormTemplate()
    {
        return 'role-based-navigation/navigation-link-form/browse';
    }



}