<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\NinjaFormsUserManagement;

use Kaiseki\Utility\NestedArray;
use Kaiseki\WordPress\Hook\HookCallbackProviderInterface;

final class FilterUserSettings implements HookCallbackProviderInterface
{
    /**
     * @param array<string, mixed> $userSettings
     */
    public function __construct(
        private readonly NestedArray $nestedArray,
        private readonly array $userSettings = []
    ) {
    }

    public function registerHookCallbacks(): void
    {
        add_filter('ninja_forms_register_user_settings', [$this, 'filterUserSettings']);
    }

    /**
     * @param array<string, mixed> $settings
     *
     * @return array<string, mixed>
     */
    public function filterUserSettings(array $settings): array
    {
        return $this->nestedArray->mergeDeep($settings, $this->getUserSettingsWithoutUnavailableFields($settings));
    }

    /**
     * @param array<string, mixed> $settings
     *
     * @return array<string, mixed>
     */
    private function getUserSettingsWithoutUnavailableFields(array $settings): array
    {
        foreach ($this->userSettings as $key => $value) {
            if (isset($settings[$key])) {
                continue;
            }
            unset($this->userSettings[$key]);
        }
        return $this->userSettings;
    }
}
