# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 1.0.0 - 2026-06-01

First tagged release.

### Added

- `FilterUserSettings` hook provider — deep-merges the configured
  `ninja_forms_user_management.user_settings` into the settings registered on the
  `ninja_forms_register_user_settings` filter, skipping any entry whose key is absent from the
  incoming settings.
- `ConfigProvider` wiring and the `FilterUserSettingsFactory`.

### Changed

- PHP requirement is `^8.2` (PHP 8.4 is the primary target).
- Modernized the dev toolchain (PHPStan 2, PHPUnit 11 schema, composer-require-checker 4); now depends
  on `kaiseki/php-coding-standard: ^1.0` with the shared PHPStan config; `kaiseki/config` and
  `kaiseki/wp-hook` pinned to `^2.0`, `kaiseki/nested-array` to `^1.0`. CI now runs via the reusable
  workflow in `kaisekidev/.github`.

### Fixed

- Removed the inline `@var` override in `FilterUserSettingsFactory`: the config value is narrowed at
  runtime (`array_filter` on string keys) instead of asserting its type. `FilterUserSettings` likewise
  narrows the merged result to string keys so its declared `array<string, mixed>` return type holds.
  No behaviour change for the string-keyed settings the plugin uses.
