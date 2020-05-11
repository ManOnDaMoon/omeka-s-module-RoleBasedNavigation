<?php
return [
    'view_manager' => [
        'template_path_stack' => [
            OMEKA_PATH . '/modules/RoleBasedNavigation/view'
        ]
    ],
    'translator' => [
        'translation_file_patterns' => [
            [
                'type' => 'gettext',
                'base_dir' => OMEKA_PATH . '/modules/RoleBasedNavigation/language',
                'pattern' => '%s.mo',
                'text_domain' => null
            ]
        ]
    ],
    'navigation_links' => [
        'invokables' => [
            'page' => RoleBasedNavigation\Site\Navigation\Link\Page::class,
            'url' => RoleBasedNavigation\Site\Navigation\Link\Url::class,
            'browse' => RoleBasedNavigation\Site\Navigation\Link\Browse::class,
            'browseItemSets' => RoleBasedNavigation\Site\Navigation\Link\BrowseItemSets::class
        ]
    ],
    'view_helpers' => [
        'factories' => [
            'navRoleSelect' => RoleBasedNavigation\Service\ViewHelper\RoleSelectFactory::class
        ]
    ],
    'form_elements' => [
        'factories' => [
            'RoleBasedNavigation\Form\Element\RoleSelect' => RoleBasedNavigation\Service\Form\Element\RoleSelectFactory::class
        ]
    ]
];
