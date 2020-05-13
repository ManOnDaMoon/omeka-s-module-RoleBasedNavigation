# omeka-s-module-RoleBasedNavigation
Module for Omeka S

This module adds the ability to filter Omeka S sites' navigation links based on user roles.

## Installing / Getting started

RoleBasedNavigation is compatible with Omeka S v2.

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
* Add one or more roles to the selector to display the link only to these roles. You can select global roles (such as *Site Administrator* or *Researcher*) or site permission roles (*Admin*, *Viewer* or *Editor*).
* Click the 'x' icon next to a role to remove it from the role selector.
* Do not forget to save your navigation tree when done.

Note that *Global Admin* roles will always be able to display the whole navigation links list at anytime.

### Apply filter on non core navigation links

This module is not able to apply directly any filters to navigation links provided by other modules.

A way to filter them anyway is to apply the role filters to a parent link, such as a URL navigation link. In case you do not want this parent to be a 'real' hypertext link, just leave its URL field to '#' and it will act as a navigation category name.

### Gotchas

Please be aware that this module only adds a view filter to the navigation, but does not add a new permission layer to your site. __The links not being displayed does not mean users can't access them with the proper URL if they effectively are granted the required Access Control List feature!__

Also please note that if roles are restricted on a site's home page, users without the adequate roles will meet a "This site has no home page" error message. I'll have a look in the near future at how to handle this more elegantly.

## Module configuration

No module configuration required.

## Known issues

See the Issues page.

## Contributing

Contributions are welcome. The module is in early development stage and could do with more advanced usage and testing.

## Links

Some code and logic based on other Omeka S modules:

* Omeka-S main repository: https://github.com/omeka/omeka-s

Also check out my other Omeka S modules:

* RestrictedSites: https://github.com/ManOnDaMoon/omeka-s-module-RestrictedSites
* UserNames: https://github.com/ManOnDaMoon/omeka-s-module-UserNames

## Licensing

The code in this project is licensed under GPLv3.
