<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    /**
     * REPLACE THE FOLLOWING ARRAYS IN YOUR Lokasi MODEL
     *
     * Replace your existing $fillable and/or $guarded and/or $appends arrays with these - we already merged
     * any existing attributes from your model, and only included the one(s) that need changing.
     */


    protected $fillable = [
        'lokasill',
        'nama_lokasi',
        'alamat',
        'latitude',
        'longtitude',
        'radius',
    ];

    protected $appends = [
        'lokasill',
    ];

    /**
     * ADD THE FOLLOWING METHODS TO YOUR Lokasi MODEL
     *
     * The 'latitude' and 'longtitude' attributes should exist as fields in your table schema,
     * holding standard decimal latitude and longitude coordinates.
     *
     * The 'lokasill' attribute should NOT exist in your table schema, rather it is a computed attribute,
     * which you will use as the field name for your Filament Google Maps form fields and table columns.
     *
     * You may of course strip all comments, if you don't feel verbose.
     */

    /**
     * Returns the 'latitude' and 'longtitude' attributes as the computed 'lokasill' attribute,
     * as a standard Google Maps style Point array with 'lat' and 'lng' attributes.
     *
     * Used by the Filament Google Maps package.
     *
     * Requires the 'lokasill' attribute be included in this model's $fillable array.
     *
     * @return array
     */

    public function getLokasillAttribute(): array
    {
        return [
            "lat" => (float)$this->latitude,
            "lng" => (float)$this->longtitude,
        ];
    }

    /**
     * Takes a Google style Point array of 'lat' and 'lng' values and assigns them to the
     * 'latitude' and 'longtitude' attributes on this model.
     *
     * Used by the Filament Google Maps package.
     *
     * Requires the 'lokasill' attribute be included in this model's $fillable array.
     *
     * @param ?array $location
     * @return void
     */
    public function setLokasillAttribute(?array $location): void
    {
        if (is_array($location)) {
            $this->attributes['latitude'] = $location['lat'];
            $this->attributes['longtitude'] = $location['lng'];
            unset($this->attributes['lokasill']);
        }
    }

    /**
     * Get the lat and lng attribute/field names used on this table
     *
     * Used by the Filament Google Maps package.
     *
     * @return string[]
     */
    public static function getLatLngAttributes(): array
    {
        return [
            'lat' => 'latitude',
            'lng' => 'longtitude',
        ];
    }

    /**
     * Get the name of the computed location attribute
     *
     * Used by the Filament Google Maps package.
     *
     * @return string
     */
    public static function getComputedLocation(): string
    {
        return 'lokasill';
    }
}
