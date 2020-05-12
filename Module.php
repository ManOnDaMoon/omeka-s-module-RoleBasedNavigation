<?php
namespace RoleBasedNavigation;

use Omeka\Module\AbstractModule;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\EventManager\Event;
use Zend\Authentication\AuthenticationService;
use Omeka\Api\Manager;
use Omeka\Settings\UserSettings;
use Omeka\Settings\SiteSettings;
use Omeka\Entity\User;

class Module extends AbstractModule
{
    /**
     * Attach to Zend and Omeka specific listeners
     */
    public function attachListeners(
        SharedEventManagerInterface $sharedEventManager
    ) {
        $sharedEventManager->attach('Omeka\Api\Adapter\SiteAdapter', 'api.read.post', array(
            $this,
            'handleSiteNavigation'
        ));
    }

    /**
     * Include the configuration array.
     *
     * {@inheritDoc}
     *
     * @see \Omeka\Module\AbstractModule::getConfig()
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     *  Filter roles in navigation array.
     *  If mismatch or unauth user: unset navigation link
     *  else
     *  recursively call filterNavigation on sub links
     *
     * @param array $navigation
     * @param array $roles
     * @return array()
     */
    public function filterNavigation(array $navigation, array $roles = [])
    {
        $filteredNavigation = [];

        $popAll = empty($roles);

        foreach ($navigation as $linkKey => $link) {
            if (isset($link['data']['role_based_navigation_role_ids'])
                && !empty($link['data']['role_based_navigation_role_ids'])) {
                if ($popAll) {
                    unset($navigation[$linkKey]);
                    continue;
                }

                $authorizedRoles = $link['data']['role_based_navigation_role_ids'];

                foreach ($authorizedRoles as $roleKey => $role){
                    if (!in_array($role, $roles)) {
                        unset($authorizedRoles[$roleKey]);
                    }
                }
                if (empty($authorizedRoles)) {
                    unset($navigation[$linkKey]);
                    continue;
                }

            }

            // If kept, recursively parse existing sub links
            if (isset($link['links']) && !empty($link['links'])) {
                $navigation[$linkKey]['links'] = $this->filterNavigation($link['links'], $roles);
            }
        }

        return $navigation;
    }

    /**
     * Parse navigation array and filter based on user role and navigation configuration.
     *
     * @param Event $event
     */
    public function handleSiteNavigation(Event $event)
    {
        /* @var \Omeka\Api\Response $response */
        /* @var \Omeka\Entity\Site $site */
        /* @var \Omeka\Mvc\Status $status */
        /* @var AuthenticationService $auth */
        /* @var Manager $api */
        /* @var UserSettings $userSettings */
        /* @var SiteSettings $siteSettings */
        /* @var User $user */

        $status = $this->serviceLocator->get('Omeka\Status');

        if ($status->isSiteRequest()) {
            if ($response = $event->getParam('response')) {
                $site = $response->getContent(); // Maybe filter on current site?

                $navigation = $site->getNavigation();

                $userRoles = array();

                $auth = $this->serviceLocator->get('Omeka\AuthenticationService');
                if ($auth->hasIdentity()) {
                    // Authenticated user, get roles and parse navigation.

                    $user = $auth->getIdentity();

                    // Get main user role@
                    $userRoles[] = $user->getRole();

                    // Get user role for this site
                    $sitePermissions = $site->getSitePermissions();
                    foreach ($sitePermissions as $sitePermission) {
                        /** @var \Omeka\Api\Representation\UserRepresentation $registeredUser */
                        /** @var \Omeka\Entity\SitePermission $$sitePermission */
                        $registeredUserId = $sitePermission->getUser()->getId();
                        if ($registeredUserId == $user->getId()) {
                            $userRoles[] = 'permission_' . $sitePermission->getRole();
                        }
                    }
                }

                $navigation = $this->filterNavigation($navigation, $userRoles);

                //  Reset navigation - Proof of concept
                $site->setNavigation($navigation); // Has this just overwritten site navigation???
            }
        }
    }
}
