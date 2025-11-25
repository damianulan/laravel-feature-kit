<?php

namespace FeatureKit\Factories;

/**
 * @author Damian Ułan <damian.ulan@protonmail.com>
 * @copyright 2025 damianulan
 * @license MIT
 */
abstract class Feature
{
    abstract public function key(): string;

    private function __construct()
    {
        //
    }
}
