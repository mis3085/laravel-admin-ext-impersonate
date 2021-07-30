<?php

namespace Mis3085\Impersonate\Actions;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mis3085\Impersonate\Impersonate;

class ImpersonateAction extends RowAction
{
    /**
     * display name
     *
     * @return string
     */
    public function name()
    {
        return __('impersonate.actions.impersonate');
    }

    /**
     * display button, work when use as individual action in a column
     *
     * @param null $value
     * @return string|null
     */
    public function display($value)
    {
        if (Impersonate::canImpersonateUser($this->getKey())) {
            return $this->name();
        }
        return null;
    }

    /**
     * authorize
     *
     * @param Model $user
     * @param Model $model
     * @return bool
     */
    public function authorize(Model $user, Model $model)
    {
        if (!Impersonate::isImpersonating() && $user->isAdministrator()) {
            return true;
        }
        return false;
    }

    /**
     * run
     *
     * @param Model $model
     * @return \Encore\Admin\Actions\Response
     */
    public function handle(Model $model)
    {
        try {
            $from = auth('admin')->user()->id;
            $to = auth('admin')->loginUsingId($model->id);

            if (!$to) {
                throw (new ModelNotFoundException)->setModel(config('admin.auth.providers.admin.model'), $model->id);
            }

            Impersonate::putImpersonator($from);

            return $this->response()->success('Refreshing...')->location(route('admin.home'));
        } catch (\Throwable $e) {
            return $this->response()->error($e->getMessage());
        }
    }

    /**
     * display dialog
     *
     * @return void
     */
    public function dialog()
    {
        $this->confirm(
            __('impersonate.confirms.impersonate.title'),
            __('impersonate.confirms.impersonate.text'),
            Impersonate::getImpersonateDialogOptions()
        );
    }
}
