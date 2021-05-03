<?php

namespace App;

// Status of a permission request to use location services.
abstract class PermissionStatus
{
/// The permission to use location services has been granted.
    const GRANTED = "granted";
    // The permission to use location services has been denied by the user. May have been denied forever on iOS.
    const DENIED = "denied";
    // The permission to use location services has been denied forever by the user. No dialog will be displayed on permission request.
    const DENIED_FOREVER = "deniedForever";
}
