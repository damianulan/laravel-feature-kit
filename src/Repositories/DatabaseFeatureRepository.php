<?php

namespace FeatureKit\Repositories;

use FeatureKit\Models\FeatureModel;
use Illuminate\Support\Facades\DB;

/**
 * @author Damian Ułan <damian.ulan@protonmail.com>
 * @copyright 2025 damianulan
 * @license MIT
 */
class DatabaseFeatureRepository extends BaseRepository
{
    protected function loadFeatures(): array
    {
        return FeatureModel::all()->toArray();
    }

}
