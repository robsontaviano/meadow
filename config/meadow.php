<?php

return [
    /**
     * Default component prefix.
     *
     * Make sure to clear view cache after renaming with `php artisan view:clear`
     *
     *    prefix => ''
     *              <x-button />
     *              <x-card />
     *
     *    prefix => 'meadow-'
     *               <x-meadow-button />
     *               <x-meadow-card />
     *
     */
    'prefix' => '',

    /**
     * Default route prefix.
     *
     * Some meadowUI components make network request to its internal routes.
     *
     *      route_prefix => ''
     *          - Spotlight: '/meadow/spotlight'
     *          - Editor: '/meadow/upload'
     *          - ...
     *
     *      route_prefix => 'my-components'
     *          - Spotlight: '/my-components/meadow/spotlight'
     *          - Editor: '/my-components/meadow/upload'
     *          - ...
     */
    'route_prefix' => '',

    /**
     * Components settings
     */
    'components' => [
        'spotlight' => [
            'class' => 'App\Support\Spotlight',
        ]
    ]
];
