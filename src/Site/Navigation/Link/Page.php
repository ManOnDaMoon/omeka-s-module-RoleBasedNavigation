<?php
namespace RoleBasedNavigation\Site\Navigation\Link;

use Omeka\Api\Representation\SiteRepresentation;

class Page extends \Omeka\Site\Navigation\Link\Page
{

    public function getFormTemplate()
    {
        return 'role-based-navigation/navigation-link-form/page';
    }

    public function toZend(array $data, SiteRepresentation $site)
    {
        $result = parent::toZend($data, $site);
        if (isset($data['role_based_navigation_role_ids'])){
            $result['role_based_navigation_role_ids'] = $data['role_based_navigation_role_ids'];
        }
        return $result;
    }

    public function toJstree(array $data, SiteRepresentation $site)
    {
        $result = parent::toJstree($data, $site);
        if (isset($data['role_based_navigation_role_ids'])){
            $result['role_based_navigation_role_ids'] = $data['role_based_navigation_role_ids'];
        }
        return $result;
    }
}