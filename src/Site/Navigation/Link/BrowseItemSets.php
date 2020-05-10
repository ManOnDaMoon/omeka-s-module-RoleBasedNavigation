<?php
namespace RoleBasedNavigation\Site\Navigation\Link;

class BrowseItemSets extends \Omeka\Site\Navigation\Link\BrowseItemSets
{

    public function getFormTemplate()
    {
        return 'role-based-navigation/navigation-link-form/browse';
    }



}