# omeka-s-module-RoleBasedNavigation
Module for Omeka S

This module adds the ability to filter Omeka S sites' navigation links based on user roles.

## Installing / Getting started

Starting v1.2, RoleBasedNavigation is compatible with Omeka S v4.

* Download and unzip in your `omeka-s/modules` directory.
* Rename the uncompressed folder to `RoleBasedNavigation`.
* Log into your Omeka S admin backend and navigate to the `Modules` menu.
* Click `Install` next to the RoleBasedNavigation module.

## Features

This module includes the following features:

* Associate global roles and site permissions to Omeka S core navigation links: Page, Url, Browse Items and Browse item sets.
* The filters are applied recursively, meaning that a main navigation category filter applies to all its child links.
* Users who do not meet these roles requirements will not see the corresponding links.

### Edit navigation roles

All navigation roles filters configuration is done when configuring your sites' navigation tree.

Navigate to your Admin Panel > Site Configuration (pencil icon), and click the *Navigation* menu.

When adding or editing (pencil icon) a new link or page in your site's navigation tree, you'll see a *Role filters* selector:

* Leave a link's role selector empty if you wish to display this link publicly
* Add one or more roles to the selector to display the link only to these roles. You can select global roles (such as *Supervisor* or *Researcher*) or site permission roles (*Manager*, *Viewer* or *Creator*).
* Click the 'x' icon next to a role to remove it from the role selector.
* Do not forget to save your navigation tree when done.

Note that *Global Admin* roles will always be able to display the whole navigation links list at anytime.

### Generic role filters

FOr more usability, this module adds generic role filters that let you display navigation items either to *Authenticated users only* or to *Unregistered visitors only*.

### Apply filter on non core navigation links

This module is not able to apply directly any filters to navigation links provided by other modules.

A way to filter them anyway is to apply the role filters to a parent link, such as a URL navigation link. In case you do not want this parent to be a 'real' hypertext link, just leave its URL field to '#' and it will act as a navigation category name.

### Role based home page

If you setup your site navigation to use the *First page in navigation* as your site's home, then you can configure different home pages based on roles.

Example use case:

* In your navigation configuration, setup the *Select a home page* option to *First page in navigation*.
* Setup your public home page as first navigation item and filter roles using the generic role filter *Unregistered visitors only*. When unregistered users will get to your site, they will land on this home page.
* Setup a second page as your second navigation item and filter roles using the generic role filter *Authenticated users only*. When registered users will browse to your site, they will be greated with this home page.
* If you wish to filter based on specific roles, you'll be able to add as many home pages as there roles on your Omeka S install.

Note that if instead of setting up the *First page in navigation* option, you explicitly name a page as the home for your site, it will still be served to all visitors without any filter applied.


### Gotchas

Please be aware that this module only adds a view filter to the navigation, but does not add a new permission layer to your site. __The links not being displayed does not mean users can't access them with the proper URL if they effectively are granted the required Access Control List feature!__

Also please note that if roles are restricted on a site's first page and that the *First page in navigation* option is enabled, users without the adequate roles will either be redirected to the next accessible page, or meet a "This site has no home page" error message.

## Module configuration

No module configuration required.

## Known issues

See the Issues page.

## Contributing

Contributions are welcome. Please use Issues and Pull Requests workflows to contribute.

## Links

Some code and logic based on other Omeka S modules:

* Omeka-S main repository: https://github.com/omeka/omeka-s

Also check out my other Omeka S modules:

* RestrictedSites: https://github.com/ManOnDaMoon/omeka-s-module-RestrictedSites
* UserNames: https://github.com/ManOnDaMoon/omeka-s-module-UserNames
* RoleBasedNavigation: https://github.com/ManOnDaMoon/omeka-s-module-RoleBasedNavigation
* Sitemaps: https://github.com/ManOnDaMoon/omeka-s-module-Sitemaps
* Siteswitcher: https://github.com/ManOnDaMoon/omeka-s-module-SiteSwitcher

## Licensing

The code in this project is licensed under GPLv3.
