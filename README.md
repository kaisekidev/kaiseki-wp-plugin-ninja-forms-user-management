# kaiseki/wp-plugin-ninja-forms-user-management

WordPress helper for the Ninja Forms User Management plugin: filter the registered user settings via
container config.

A single `kaiseki/wp-hook` `HookProviderInterface` wired through `ConfigProvider`:

- **`FilterUserSettings`** — hooks the `ninja_forms_register_user_settings` filter and deep-merges your
  configured `user_settings` into the settings Ninja Forms User Management registers. Keys whose target
  setting isn't present in the incoming settings are dropped, so you only ever extend settings the
  plugin actually exposes.

## Installation

```bash
composer require kaiseki/wp-plugin-ninja-forms-user-management
```

Requires PHP 8.2 or newer.

## Usage

Register `ConfigProvider` with your laminas-style config aggregator, configure the
`ninja_forms_user_management` key, and activate the provider via `kaiseki/wp-hook`:

```php
use Kaiseki\WordPress\NinjaFormsUserManagement\FilterUserSettings;

return [
    'ninja_forms_user_management' => [
        // Merged into the settings registered on `ninja_forms_register_user_settings`.
        // Keyed by setting name; entries whose key is absent in the incoming
        // settings are skipped.
        'user_settings' => [
            'user_role' => [
                'name'  => 'user_role',
                'type'  => 'select',
                'label' => __('User Role', 'my-textdomain'),
            ],
        ],
    ],
    'hook' => [
        'provider' => [
            FilterUserSettings::class,
        ],
    ],
];
```

`ConfigProvider` registers the `FilterUserSettings` factory, which reads
`ninja_forms_user_management.user_settings` from the container and injects the shared
`Kaiseki\Utility\NestedArray` used for the deep merge.

## Development

```bash
composer install
composer check   # check-deps, cs-check, phpstan
```

## License

MIT — see [LICENSE](LICENSE).
