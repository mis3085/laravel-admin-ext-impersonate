laravel-admin extension - Impersonate
======
Allow administrator to impersonate other backend user.

## Publish lang files
```
php artisan vendor:publish --tag=impersonate-lang
```

## Configuration
Insert into `extensions` section in `config/admin.php` if u want to customize.
```
    'impersonate' => [
        'dialogs' => [
            'impersonate' => [
                'position' => 'center-right',
            ],
        ],
        'session_keys' => [
            'impersonator' => 'impersonator',
        ]
    ],
```

## Usage
* Edit `app\Admin\routes.php` to override the original UserController routes
  ```
  $router->resource('auth/users', 'UserController')->names('auth.users');
  ```
* Create `app\Admin\Controllers\UserController`
  * Extends `Encore\Admin\Controllers\UserController`
  * Copy `grid()` from `Encore\Admin\Controllers\UserController`
  * Modify `grid()`
    * Use as action in a column
      ```
      use Mis3085\Impersonate\Actions\ImpersonateAction;

      $grid->column('ANY_TEXT', 'ANY_TEXT')->action(ImpersonateAction::class);
      ```

    * Use as dropdown action
      ```
      use Mis3085\Impersonate\Actions\ImpersonateAction;

      $grid->actions(function (Grid\Displayers\Actions $actions) {
          if (Impersonate::canImpersonateUser($actions->getKey())) {
              $actions->add(new ImpersonateAction);
          }

          // other actions
      });
      ```
