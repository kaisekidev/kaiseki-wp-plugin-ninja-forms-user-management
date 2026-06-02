<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\NinjaFormsUserManagement;

use Kaiseki\Config\Config;
use Kaiseki\Utility\NestedArray;
use Psr\Container\ContainerInterface;

use function array_filter;
use function is_string;

use const ARRAY_FILTER_USE_KEY;

final class FilterUserSettingsFactory
{
    public function __invoke(ContainerInterface $container): FilterUserSettings
    {
        $config = Config::fromContainer($container);
        $userSettings = array_filter(
            $config->array('ninja_forms_user_management.user_settings'),
            static fn(int|string $key): bool => is_string($key),
            ARRAY_FILTER_USE_KEY
        );

        return new FilterUserSettings(
            $container->get(NestedArray::class),
            $userSettings
        );
    }
}
