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
                            'text_domain' => null,
                        ],
                ],
        ],
];
