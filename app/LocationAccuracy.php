<?php

namespace App;

abstract class LocationAccuracy
{
    const POWERSAVE = "powerSave"; // To request best accuracy possible with zero additional power consumption,
    const LOW = "low"; // To request "city" level accuracy
    const BALANCED = "balanced"; // To request "block" level accuracy
    const HIGH = "high"; // To request the most accurate locations available
    const NAVIGATION = "navigation"; // To request location for navigation usage (affect only iOS)
}
