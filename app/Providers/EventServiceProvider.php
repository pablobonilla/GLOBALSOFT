<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            // Add some items to the menu...
            $event->menu->add([
                'text'        => __('Dashboard'),
                'url'         => 'Dashboard/',
                'icon'        => 'fas fa-fw fa-th'
            ]);

            $event->menu->add([
                'text'        => __('Facturación'),
                'url'         => 'facturacion/',
                'icon'        => 'fas fa-fw fa-circle'
            ]);

            $event->menu->add([
                'text'        => __('Compras'),
                'url'         => 'areas/',
                'icon'        => 'fas fa-fw fa-circle'
            ]);

            $event->menu->add([
                'text'        => __('Inventario'),
                'url'         => 'inventario/',
                'icon'        => 'fas fa-warehouse'
            ]);

            $event->menu->add([
                'text'        => __('cxc'),
                'url'         => 'cxc/',
                'icon'        => 'fas fa-fw fa-circle'
            ]);

            $event->menu->add([
                'text'        => __('cxp'),
                'url'         => 'cxp/',
                'icon'        => 'fas fa-fw fa-circle'
            ]);

            $event->menu->add([
                'text'        => __('Productos'),
                'url'         => 'producto/',
                'icon'        => 'fas fa-fw fa-circle'
            ]);



            $event->menu->add([
                'text'    => __('Reportes'),
                'icon'    => 'fas fa-fw fa-file-alt',
                'submenu' => [
                    [
                        'text'        => __('Facturas Emitidas'),
                        'url'         => '',
                        'icon'        => 'fas fa-fw fa-circle'
                    ],
                    [
                        'text'        => __('Deudas Pendientes'),
                        'url'         => '',
                        'icon'        => 'fas fa-fw fa-circle'
                    ]
                    ,
                    [
                        'text'        => __('Ingresos y Gastos'),
                        'url'         => '',
                        'icon'        => 'fas fa-fw fa-circle'
                    ]

                ]
            ]);

            $event->menu->add(__('CONFIGURACION'));

            $event->menu->add([
                'text'        => __('Configuración'),
                'url'         => 'configuracion/',
                'icon'        => 'fas fa-fw fa-cogs'
            ]);

            $event->menu->add(__('CONFIGURACION DE LA CUENTA'));

            $event->menu->add([
                'text'        => __('profile'),
                'url'  => 'admin/settings',
                'icon' => 'fas fa-fw fa-user',
            ]);

            $event->menu->add([
                'text'        => __('change_password'),
                'url'  => 'admin/settings',
                'icon' => 'fas fa-fw fa-lock',
            ]);

            $event->menu->add([
                'text'    => 'multilevel',
                'icon'    => 'fas fa-fw fa-share',
                'submenu' => [
                    [
                        'text' => 'level_one',
                        'url'  => '#',
                    ],
                    [
                        'text'    => 'level_one',
                        'url'     => '#',
                        'submenu' => [
                            [
                                'text' => 'level_two',
                                'url'  => '#',
                            ],
                            [
                                'text'    => 'level_two',
                                'url'     => '#',
                                'submenu' => [
                                    [
                                        'text' => 'level_three',
                                        'url'  => '#',
                                    ],
                                    [
                                        'text' => 'level_three',
                                        'url'  => '#',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    [
                        'text' => 'level_one',
                        'url'  => '#',
                    ],
                ]
            ]);
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
