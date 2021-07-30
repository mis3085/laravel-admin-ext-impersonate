<?php

namespace Mis3085\Impersonate\Actions;

use Encore\Admin\Actions\Action;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mis3085\Impersonate\Impersonate;

class RevokeAction extends Action
{
    protected $selector = '.impersonate-revoke';

    /**
     * run
     *
     * @return \Encore\Admin\Actions\Response
     */
    public function handle()
    {
        try {
            $impersonator = Impersonate::pullImpersonator();

            $user = auth('admin')->loginUsingId($impersonator);

            if (!$user) {
                throw (new ModelNotFoundException)->setModel(config('admin.auth.providers.admin.model'), $impersonator);
            }

            return $this->response()->location(route('admin.home'));
        } catch (\Throwable $e) {
            return $this->response()->error($e->getMessage());
        }
    }

    /**
     * display button
     *
     * @return string
     */
    public function html()
    {
        if (!Impersonate::isImpersonating()) {
            return '';
        }

        return view('impersonate::revoke')->with([
            'class' => trim($this->selector, '.'),
            'label' => __('impersonate.actions.revoke'),
            'name'  => $this->getActionName()
        ])->render();
    }

    /**
     * return full class name
     *
     * @return string
     */
    protected function getActionName()
    {
        return str_replace('\\', '_', __CLASS__);
    }
}
