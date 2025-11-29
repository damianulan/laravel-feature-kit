<?php

use FeatureKit\Factories\Feature;
use FeatureKit\Features;

if (! function_exists('feature')) {
    function feature(string $key, $user = null): bool
    {
        return app(Features::class)->check($key, $user);
    }
}

if (! function_exists('get_feature')) {
    function get_feature(string $key, $user = null): ?Feature
    {
        return app(Features::class)->find($key, $user);
    }
}
