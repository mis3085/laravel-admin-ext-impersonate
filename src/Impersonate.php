<?php

namespace Mis3085\Impersonate;

use Encore\Admin\Extension;

class Impersonate extends Extension
{
    public $name = 'impersonate';

    public $views = __DIR__ . '/../resources/views';

    /**
     * return dialog options for SweetAlert
     *
     * @return array
     */
    public static function getImpersonateDialogOptions()
    {
        static $options = null;

        if (is_null($options)) {
            $options = self::config('dialogs.impersonate', ['position' => 'center-right']);
        }

        return $options;
    }

    /**
     * whether display button
     *
     * @param int|string $id
     * @return boolean
     */
    public static function canImpersonateUser($id)
    {
        return !self::isImpersonating() && $id != auth('admin')->user()->id;
    }

    /**
     * return impersonator key from config
     *
     * @return string
     */
    public static function getImpersonatorKey()
    {
        return self::config('session_keys.impersonator', 'impersonator');
    }

    /**
     * return if session has impersonator
     *
     * @return boolean
     */
    public static function isImpersonating()
    {
        return session()->has(self::getImpersonatorKey());
    }

    /**
     * get impersontor from session
     *
     * @return int|string|null
     */
    public static function getImpersonator()
    {
        return decrypt(session()->get(self::getImpersonatorKey()));
    }

    /**
     * pull impersonator from session
     *
     * @return int|string|null
     */
    public static function pullImpersonator()
    {
        return decrypt(session()->pull(self::getImpersonatorKey()));
    }

    /**
     * put impersonator into session
     *
     * @param int|string $value
     * @return void
     */
    public static function putImpersonator($value)
    {
        session()->put(self::getImpersonatorKey(), encrypt($value));
    }
}
