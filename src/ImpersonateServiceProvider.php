<?php

namespace Mis3085\Impersonate;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Widgets\Navbar;
use Mis3085\Impersonate\Actions\RevokeAction;
use Illuminate\Support\ServiceProvider;

class ImpersonateServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(Impersonate $extension)
    {
        if (! Impersonate::boot()) {
            return ;
        }

        // views
        $this->loadViewsFrom($extension->views(), $extension->name);

        // lang
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../resources/lang' => resource_path('lang')], $extension->name . '-lang');
        }

        // append button to navbar
        Admin::booting(function () {
            Admin::navbar(function (Navbar $navbar) {
                if (auth('admin')->check()) {
                    $navbar->right(new RevokeAction);
                }
            });
        });
    }
}
