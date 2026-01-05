<?php

use FeatureKit\Factories\Feature;
use FeatureKit\Features;

if (! function_exists('features')) {

    /**
     * Get collection of all features registered in FeatureKit
     *
     * @return \FeatureKit\Features
     */
    function features(): Features
    {
        return app(Features::class);
    }
}

if (! function_exists('feature')) {

    /**
     * Check if feature is on or off. Use $user for context if needed.
     *
     * @param string $key
     * @param mixed  $user - by default it will be current user
     * @return bool
     */
    function feature(string $key, $user = null): bool
    {
        return app(Features::class)->check($key, $user);
    }
}

if (! function_exists('get_feature')) {

    /**
     * Get feature instance
     *
     * @param string $key
     * @param mixed  $user
     * @return \FeatureKit\Factories\Feature|null
     */
    function get_feature(string $key, $user = null): ?Feature
    {
        return app(Features::class)->find($key, $user);
    }
}
