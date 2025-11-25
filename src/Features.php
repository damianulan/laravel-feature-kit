<?php

namespace FeatureKit;

use FeatureKit\Helpers\KitHelper;
use Illuminate\Support\Collection;

/**
 * @author Damian Ułan <damian.ulan@protonmail.com>
 * @copyright 2025 damianulan
 * @license MIT
 */
class Features extends Collection
{
    public function __construct()
    {
        $items = KitHelper::repository()->getFeatures();
        parent::__construct($items);
    }
}
