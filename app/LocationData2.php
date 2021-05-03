<?php

namespace App;

class LocationData
{
    protected $latitude; // Latitude, in degrees
    protected $longitude; // Longitude, in degrees
    protected $accuracy; // Estimated horizontal accuracy of this location, radial, in meters
    protected $altitude; // In meters above the WGS 84 reference ellipsoid
    protected $speed; // In meters/second
    protected $speedAccuracy; // In meters/second, always 0 on iOS
    protected $heading; //Heading is the horizontal direction of travel of this device, in degrees
    protected $time; //timestamp of the LocationData
}





