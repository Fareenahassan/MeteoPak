<?php

namespace App\Repositories;

use App\Models\Region;
use App\Models\Station;

class RegionStationRepository
{
    /**
     * Get all regions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllRegions()
    {
        return Region::all();
    }

    /**
     * Get all stations.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllStations()
    {
        return Station::with('region')->get();
    }

    /**
     * Get stations by region ID.
     *
     * @param int $regionId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getStationsByRegion(int $regionId)
    {
        return Station::where('region_id', $regionId)->get();
    }

    /**
     * Get region by ID.
     *
     * @param int $id
     * @return Region|null
     */
    public function getRegionById(int $id)
    {
        return Region::find($id);
    }

    /**
     * Get station by ID.
     *
     * @param int $id
     * @return Station|null
     */
    public function getStationById(int $id)
    {
        return Station::with('region')->find($id);
    }

    /**
     * Create a new region.
     *
     * @param array $data
     * @return Region
     */
    public function createRegion(array $data)
    {
        return Region::create($data);
    }

    /**
     * Create a new station.
     *
     * @param array $data
     * @return Station
     */
    public function createStation(array $data)
    {
        return Station::create($data);
    }

    /**
     * Update a region.
     *
     * @param Region $region
     * @param array $data
     * @return Region
     */
    public function updateRegion(Region $region, array $data)
    {
        $region->update($data);
        return $region;
    }

    /**
     * Update a station.
     *
     * @param Station $station
     * @param array $data
     * @return Station
     */
    public function updateStation(Station $station, array $data)
    {
        $station->update($data);
        return $station;
    }

    /**
     * Delete a region.
     *
     * @param Region $region
     * @return bool|null
     */
    public function deleteRegion(Region $region)
    {
        // This will cascade delete stations due to foreign key constraint
        return $region->delete();
    }

    /**
     * Delete a station.
     *
     * @param Station $station
     * @return bool|null
     */
    public function deleteStation(Station $station)
    {
        return $station->delete();
    }

    /**
     * Get regions with stations.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRegionsWithStations()
    {
        return Region::with('stations')->get();
    }
}