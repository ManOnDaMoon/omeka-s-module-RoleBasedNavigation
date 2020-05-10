<?php
namespace RoleBasedNavigation\Site\Navigation\Link;

class Url extends \Omeka\Site\Navigation\Link\Url
{

    public function getFormTemplate()
    {
        return 'role-based-navigation/navigation-link-form/url';
    }



}