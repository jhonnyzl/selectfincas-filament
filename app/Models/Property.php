<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'reference_id',
        'property_type_id',
        'operation_id',
        'property_status_id',
        'address',
        'locality',
        'postal_code',
        'province_id',
        'latitude',
        'longitude',
        'zone_id',
        'constructed_area',
        'usable_area',
        'land_area',
        'rooms',
        'bathrooms',
        'floors',
        'construction_year',
        'housing_type',
        'living_room',
        'equipped_kitchen',
        'terrace',
        'garden',
        'pool',
        'storage_room',
        'garage',
        'orientation',
        'views',
        'air_conditioning',
        'fireplace',
        'heating',
        'drinking_water',
        'electricity',
        'internet',
        'well',
        'solar_panels',
        'security_system',
        'accessible',
        'land_type',
        'current_crops',
        'own_well',
        'agricultural_facilities',
        'fenced',
        'road_access',
        'topography',
        'price',
        'commission',
        'community_fees',
        'ibi',
        'estimated_profitability',
        'short_description',
        'long_description',
        'internal_notes',
        'gallery',
        'video',
        'virtual_tour',
        'blueprint',
        'brochure',
    ];

    protected $casts = [
        'gallery' => 'array',
        'video' => 'string',
        'virtual_tour' => 'string',
        'blueprint' => 'string',
        'brochure' => 'string',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($property) {
            if (empty($property->slug)) {
                $property->slug = str($property->title)->slug();
            }
        });

        static::saving(function ($property) {
            // Solo generar un nuevo slug si el título cambia y el slug no ha sido modificado manualmente
            if ($property->isDirty('title') && !$property->isDirty('slug')) {
                $property->slug = str($property->title)->slug();
            }
        });
    }

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function operation()
    {
        return $this->belongsTo(Operation::class);
    }

    public function propertyStatus()
    {
        return $this->belongsTo(PropertyStatus::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}
