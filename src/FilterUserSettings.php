<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\NinjaFormsUserManagement;

use Kaiseki\Utility\NestedArray;
use Kaiseki\WordPress\Hook\HookProviderInterface;

use function add_filter;

final class FilterUserSettings implements HookProviderInterface
{
    /**
     * @param NestedArray          $nestedArray
     * @param array<string, mixed> $userSettings
     */
    public function __construct(
        private readonly NestedArray $nestedArray,
        private readonly array $userSettings = []
    ) {
    }

    public function addHooks(): void
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
        if ($this->userSettings === []) {
            return $settings;
        }

        return $this->nestedArray->mergeDeep($settings, $this->getUserSettingsWithoutUnavailableFields($settings));
    }

    /**
     * @param array<string, mixed> $settings
     *
     * @return array<string, mixed>
     */
    private function getUserSettingsWithoutUnavailableFields(array $settings): array
    {
        $updatedUserSettings = $this->userSettings;

        foreach ($updatedUserSettings as $key => $value) {
            if (isset($settings[$key])) {
                continue;
            }
            unset($updatedUserSettings[$key]);
        }

        return $updatedUserSettings;
    }
}
