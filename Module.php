<?php
namespace RoleBasedNavigation;

use Composer\Semver\Comparator;
use Omeka\Module\AbstractModule;
use Zend\EventManager\EventInterface;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Controller\AbstractController;
use Zend\EventManager\SharedEventManagerInterface;
use Omeka\Permissions\Acl;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\Container;
use Zend\View\Renderer\PhpRenderer;
use Zend\Http\PhpEnvironment\Response;
use Zend\EventManager\Event;
use Omeka\Api\Representation\SiteRepresentation;
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
    )
    {
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
     *  Check roles
     *  If mismatch or guest: pop $link
     *  else
     *  recursively call filterNavigation on sub links
     *
     * @param array $navigation
     * @param array $roles
     * @return unknown
     */
    public function filterNavigation(array $navigation, array $roles = [])
    {
        $filteredNavigation = [];

        $popAll = empty($roles);

        foreach($navigation as $key => $link) {
            if (isset($link['data']['role_based_navigation_role_ids'])
                && !empty($link['data']['role_based_navigation_role_ids'])) {

                if ($popAll) {
                    unset($navigation[$key]);
                    continue;
                }
            }

            // Recursively parse sub levels
            if (isset($link['links']) && !empty($link['links'])) {
                $navigation[$key]['links'] = $this->filterNavigation($link['links'], $roles);
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

                $site = $response->getContent();

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
                        if ($registeredUserId == $user->getId())
                        {
                            $userRoles[] = 'permission_' . $sitePermission->getRole();
                        }
                    }
                }

                $navigation = $this->filterNavigation($navigation, $userRoles);

                //  Reset navigation - Proof of concept
                $site->setNavigation($navigation);
            }
        }
    }
}
