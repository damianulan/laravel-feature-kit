<?php

use FeatureKit\Factories\Feature;

if (! function_exists('feature')) {
    function feature(string $key): bool
    {
        return false;
    }
}
