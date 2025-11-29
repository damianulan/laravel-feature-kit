<?php

namespace FeatureKit\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureModel extends Model
{
    protected $table;

    protected $fillable = [
        'key',
        'enabled',
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('featurekit.drivers.database.table_name');

        parent::__construct($attributes);
    }
}
