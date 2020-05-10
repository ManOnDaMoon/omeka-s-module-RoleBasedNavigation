<?php
namespace RoleBasedNavigation\Site\Navigation\Link;

class Page extends \Omeka\Site\Navigation\Link\Page
{

    public function getFormTemplate()
    {
        return 'role-based-navigation/navigation-link-form/page';
    }



}