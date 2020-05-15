<?php
namespace RoleBasedNavigation\Site\Navigation\Link;

use Omeka\Api\Representation\SiteRepresentation;
use RoleBasedNavigation\Module;

class BrowseItemSets extends \Omeka\Site\Navigation\Link\BrowseItemSets
{
    public function getFormTemplate()
    {
        return 'role-based-navigation/navigation-link-form/browse';
    }

    protected function _filterRoleSelectors(array $roleSelectors)
    {
        if (in_array(Module::RBN_AUTHENTICATED_USERS, $roleSelectors)) {
            if (in_array(Module::RBN_UNAUTHENTICATED_VISITORS, $roleSelectors)) {
                return []; // equivalent to empty selection
            } else {
                return [
                    Module::RBN_AUTHENTICATED_USERS
                ];
            }
        } elseif (in_array(Module::RBN_UNAUTHENTICATED_VISITORS, $roleSelectors)) {
            return [
                Module::RBN_UNAUTHENTICATED_VISITORS
            ];
        } else {
            return $roleSelectors;
        }
    }

    public function toZend(array $data, SiteRepresentation $site)
    {
        $result = parent::toZend($data, $site);
        if (isset($data['role_based_navigation_role_ids'])) {
            $result['role_based_navigation_role_ids'] = $this->_filterRoleSelectors($data['role_based_navigation_role_ids']);
        }
        return $result;
    }

    public function toJstree(array $data, SiteRepresentation $site)
    {
        $result = parent::toJstree($data, $site);
        if (isset($data['role_based_navigation_role_ids'])) {
            $result['role_based_navigation_role_ids'] = $this->_filterRoleSelectors($data['role_based_navigation_role_ids']);
        }
        return $result;
    }
}
