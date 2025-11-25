<?php

namespace FeatureKit\Repositories;

use FeatureKit\Models\FeatureModel;
use Illuminate\Support\Facades\DB;

/**
 * @author Damian Ułan <damian.ulan@protonmail.com>
 * @copyright 2025 damianulan
 * @license MIT
 */
abstract class BaseRepository
{
    protected array $features = [];

    abstract protected function loadFeatures(): array;

    public function __construct()
    {
        $this->loadFeatures();


    }

    private function analyzeFeatures(): void
    {
        //
    }

    public function getFeatures(): array
    {
        return $this->features;
    }
}
