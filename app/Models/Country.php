<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'region_id',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * Get all countries grouped by region
     */
    public static function getAllGroupedByRegion()
    {
        return self::with('region')
            ->orderBy('region_id')
            ->orderBy('name')
            ->get()
            ->groupBy('region.name');
    }

    /**
     * Get all countries as a flat array for select options
     */
    public static function getAllForSelect()
    {
        return self::with('region')
            ->orderBy('region_id')
            ->orderBy('name')
            ->get()
            ->map(function ($country) {
                return [
                    'value' => $country->name,
                    'label' => $country->name,
                    'region' => $country->region->name
                ];
            });
    }

    /**
     * Get countries by region name
     */
    public static function getByRegion($regionName)
    {
        return self::whereHas('region', function ($query) use ($regionName) {
            $query->where('name', $regionName);
        })->pluck('name')->toArray();
    }
}
