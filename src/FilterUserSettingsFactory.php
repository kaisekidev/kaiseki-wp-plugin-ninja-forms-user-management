<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\NinjaFormsUserManagement;

use Kaiseki\Config\Config;
use Kaiseki\Utility\NestedArray;
use Psr\Container\ContainerInterface;

final class FilterUserSettingsFactory
{
    public function __invoke(ContainerInterface $container): FilterUserSettings
    {
        $config = Config::get($container);
        /** @var array<mixed> $userSettings */
        $userSettings = $config->array('ninja_forms_user_management/user_settings', []);
        return new FilterUserSettings(
            $container->get(NestedArray::class),
            $userSettings
        );
    }
}
