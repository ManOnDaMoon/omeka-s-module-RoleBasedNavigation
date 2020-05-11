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
            'filterNavigation'
        ));

        $sharedEventManager->attach('Omeka\Api\Adapter\SiteAdapter', 'api.update.post', array(
            $this,
            'updateNavigation'
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
     * Upgrade this module.
     *
     * @param string $oldVersion
     * @param string $newVersion
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function upgrade($oldVersion, $newVersion, ServiceLocatorInterface $serviceLocator)
    {
//         $api = $serviceLocator->get('Omeka\ApiManager');
//         $sites = $api->search('sites', [])->getContent();
//         /** @var \Omeka\Settings\SiteSettings $siteSettings */
//         $siteSettings = $serviceLocator->get('Omeka\Settings\Site');

//         // v0.10 renamed site setting ID from 'restricted' to 'restrictedsites_restricted'
//         if (Comparator::lessThan($oldVersion, '0.10')) {
//             foreach ($sites as $site) {
//                 $siteSettings->setTargetId($site->id());
//                 if ($oldSetting = $siteSettings->get('restricted', null)) {
//                     $siteSettings->set('restrictedsites_restricted', $oldSetting);
//                     $siteSettings->delete('restricted');
//                 }
//             }
//         }
    }

    public function uninstall(ServiceLocatorInterface $serviceLocator)
    {
//         $settings = $serviceLocator->get('Omeka\Settings');
//         $settings->delete('restrictedsites_custom_email');

//         $api = $serviceLocator->get('Omeka\ApiManager');
//         $sites = $api->search('sites', [])->getContent();
//         $siteSettings = $serviceLocator->get('Omeka\Settings\Site');

//         foreach ($sites as $site) {
//             $siteSettings->setTargetId($site->id());
//             $siteSettings->delete('restrictedsites_restricted');
//         }
    }

    /**
     * Get this module's configuration form.
     *
     * @param PhpRenderer $renderer
     * @return string
     */
    public function getConfigForm(PhpRenderer $renderer)
    {
//         $formElementManager = $this->getServiceLocator()->get('FormElementManager');
//         $form = $formElementManager->get(ConfigForm::class, []);
//         return $renderer->formCollection($form, false);
    }

    /**
     * Handle this module's configuration form.
     *
     * @param AbstractController $controller
     * @return bool False if there was an error during handling
     */
    public function handleConfigForm(AbstractController $controller)
    {
//         $params = $controller->params()->fromPost();
//         if (isset($params['restrictedsites_custom_email'])) {
//             $customEmailSetting = $params['restrictedsites_custom_email'];
//         }

//         $globalSettings = $this->getServiceLocator()->get('Omeka\Settings');
//         $globalSettings->set('restrictedsites_custom_email', $customEmailSetting);
    }

    /**
     * {@inheritDoc}
     *
     * @see \Omeka\Module\AbstractModule::onBootstrap()
     */
    public function onBootstrap(MvcEvent $event)
    {
        parent::onBootstrap($event);
    }

    public function updateNavigation(Event $event)
    {
        /* @var \Omeka\Api\Response $response */
        /* @var \Omeka\Api\Request $request */
        /* @var \Omeka\Entity\Site $site */
        /* @var \Omeka\Mvc\Status $status */

        $status = $this->serviceLocator->get('Omeka\Status');
        $isNavUpdate = $status->getRouteMatch('admin/site/navigation');

        if ($response = $event->getParam('response')) {

            $request = $event->getParam('request');

            $siteId = $request->getId();
            $navigationData = $request->getContent();

            // Do the work on updated navigation data
        }
    }

    public function filterNavigation(Event $event)
    {
        /* @var \Omeka\Api\Response $response */
        /* @var \Omeka\Entity\Site $site */
        /* @var \Omeka\Mvc\Status $status */

        $status = $this->serviceLocator->get('Omeka\Status');

        if ($status->isSiteRequest()) {

            if ($response = $event->getParam('response')) {

                $site = $response->getContent();

                //  Reset navigation - Proof of concept
                $site->setNavigation(array());
            }
        }
    }
}
