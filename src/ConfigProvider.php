<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\NinjaFormsUserManagement;

final class ConfigProvider
{
    /**
     * @return array<mixed>
     */
    public function __invoke(): array
    {
        return [
            'ninja_forms_user_management' => [
                'user_settings' => [],
            ],
            'hook' => [
                'provider' => [],
            ],
            'dependencies' => [
                'aliases' => [],
                'factories' => [
                    FilterUserSettings::class => FilterUserSettingsFactory::class,
                ],
            ],
        ];
    }
}
