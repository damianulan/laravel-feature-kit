<?php

namespace FeatureKit\Repositories;

use FeatureKit\Models\FeatureModel;
use Illuminate\Support\Facades\DB;
use FeatureKit\Factories\Feature;

/**
 * @author Damian Ułan <damian.ulan@protonmail.com>
 * @copyright 2025 damianulan
 * @license MIT
 */
class DatabaseFeatureRepository extends BaseRepository
{
    protected function loadRegisteredFeatures(): array
    {
        return FeatureModel::all()->toArray();
    }

    public function create(Feature $feature): Feature
    {
        return $feature;
    }

    public function delete(Feature $feature): Feature
    {
        return $feature;
    }
}
