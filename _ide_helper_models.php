<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Arrival
 *
 * @property int $id
 * @property int $employee_ride_id
 * @property int $terminal_id
 * @property string $or_no
 * @property \Illuminate\Support\Carbon $time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\EmployeeRide $employeeRide
 * @method static \Illuminate\Database\Eloquent\Builder|Arrival newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Arrival newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Arrival query()
 * @method static \Illuminate\Database\Eloquent\Builder|Arrival whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Arrival whereEmployeeRideId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Arrival whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Arrival whereOrNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Arrival whereTerminalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Arrival whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Arrival whereUpdatedAt($value)
 */
	class Arrival extends \Eloquent {}
}

namespace App{
/**
 * App\Booking
 *
 * @property int $id
 * @property string $booking_code
 * @property int $ride_id
 * @property int $passenger_id
 * @property int $start_terminal_id
 * @property int $end_terminal_id
 * @property int $pax
 * @property int $aboard
 * @property string $status
 * @property string|null $reason
 * @property string $travel_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Bus $bus
 * @property-read \App\Terminal $endTerminal
 * @property-read mixed $payment
 * @property-read \App\User $passenger
 * @property-read \App\Ride $ride
 * @property-read \App\Sale|null $sale
 * @property-read \App\Terminal $startTerminal
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereAboard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereBookingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereEndTerminalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking wherePassengerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking wherePax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereRideId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereStartTerminalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereTravelDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Booking whereUpdatedAt($value)
 */
	class Booking extends \Eloquent {}
}

namespace App{
/**
 * App\Bus
 *
 * @property int $id
 * @property int $company_id
 * @property int $bus_class_id
 * @property int $bus_no
 * @property string $bus_name
 * @property string $bus_plate
 * @property int $bus_seat
 * @property int|null $driver_id
 * @property int|null $conductor_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\BusClass $busClass
 * @property-read \App\User|null $conductor
 * @property-read \App\User|null $driver
 * @property-read mixed $rate_per_km
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ride[] $rides
 * @property-read int|null $rides_count
 * @method static \Illuminate\Database\Eloquent\Builder|Bus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bus query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bus whereBusClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bus whereBusName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bus whereBusNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bus whereBusPlate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bus whereBusSeat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bus whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bus whereConductorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bus whereDriverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bus whereUpdatedAt($value)
 */
	class Bus extends \Eloquent {}
}

namespace App{
/**
 * App\BusClass
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property float $rate
 * @property float|null $point
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BusClass newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusClass newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusClass query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusClass whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusClass whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusClass whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusClass whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusClass wherePoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusClass whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusClass whereUpdatedAt($value)
 */
	class BusClass extends \Eloquent {}
}

namespace App{
/**
 * App\BusCompanyProfile
 *
 * @property int $id
 * @property string $company_name
 * @property string $company_address
 * @property string $company_contact
 * @property string $company_mission
 * @property string $company_profile
 * @property int $activate_point
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\BusClass[] $busClasses
 * @property-read int|null $bus_classes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Bus[] $buses
 * @property-read int|null $buses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Employee[] $employees
 * @property-read int|null $employees_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Ride[] $rides
 * @property-read int|null $rides_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Route[] $routes
 * @property-read int|null $routes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Terminal[] $terminals
 * @property-read int|null $terminals_count
 * @method static \Illuminate\Database\Eloquent\Builder|BusCompanyProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusCompanyProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusCompanyProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusCompanyProfile whereActivatePoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusCompanyProfile whereCompanyAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusCompanyProfile whereCompanyContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusCompanyProfile whereCompanyMission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusCompanyProfile whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusCompanyProfile whereCompanyProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusCompanyProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusCompanyProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusCompanyProfile whereUpdatedAt($value)
 */
	class BusCompanyProfile extends \Eloquent {}
}

namespace App{
/**
 * App\BusLocation
 *
 * @property int $id
 * @property int $ride_id
 * @property int $conductor_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BusLocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusLocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusLocation query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusLocation whereConductorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusLocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusLocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusLocation whereRideId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusLocation whereUpdatedAt($value)
 */
	class BusLocation extends \Eloquent {}
}

namespace App{
/**
 * App\ConductorHistory
 *
 * @property int $id
 * @property int $ride_id
 * @property int $conductor_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ConductorHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConductorHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConductorHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConductorHistory whereConductorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConductorHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConductorHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConductorHistory whereRideId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConductorHistory whereUpdatedAt($value)
 */
	class ConductorHistory extends \Eloquent {}
}

namespace App{
/**
 * App\Departure
 *
 * @property int $id
 * @property int $employee_ride_id
 * @property int $terminal_id
 * @property string $or_no
 * @property string $time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\EmployeeRide $employeeRide
 * @method static \Illuminate\Database\Eloquent\Builder|Departure newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Departure newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Departure query()
 * @method static \Illuminate\Database\Eloquent\Builder|Departure whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Departure whereEmployeeRideId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Departure whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Departure whereOrNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Departure whereTerminalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Departure whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Departure whereUpdatedAt($value)
 */
	class Departure extends \Eloquent {}
}

namespace App{
/**
 * App\Employee
 *
 * @property int $id
 * @property int $user_id
 * @property string $employee_no
 * @property string $first_name
 * @property string $last_name
 * @property string $address
 * @property string $contact
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $full_name
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereEmployeeNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUserId($value)
 */
	class Employee extends \Eloquent {}
}

namespace App{
/**
 * App\EmployeeRide
 *
 * @property int $id
 * @property string $ride_code
 * @property int $ride_id
 * @property int $conductor_id
 * @property int $driver_id
 * @property string $travel_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Arrival|null $arrival
 * @property-read \App\User $conductor
 * @property-read \App\Departure|null $departure
 * @property-read \App\User $driver
 * @property-read \App\Ride $ride
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRide newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRide newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRide query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRide whereConductorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRide whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRide whereDriverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRide whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRide whereRideCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRide whereRideId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRide whereTravelDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeRide whereUpdatedAt($value)
 */
	class EmployeeRide extends \Eloquent {}
}

namespace App{
/**
 * App\LocationData
 *
 * @method static \Illuminate\Database\Eloquent\Builder|LocationData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LocationData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LocationData query()
 */
	class LocationData extends \Eloquent {}
}

namespace App{
/**
 * App\PassengerProfile
 *
 * @property int $id
 * @property int $passenger_id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $middle_name
 * @property string|null $name_extension
 * @property string $contact
 * @property string $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $full_name
 * @method static \Illuminate\Database\Eloquent\Builder|PassengerProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PassengerProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PassengerProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder|PassengerProfile whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PassengerProfile whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PassengerProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PassengerProfile whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PassengerProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PassengerProfile whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PassengerProfile whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PassengerProfile whereNameExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PassengerProfile wherePassengerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PassengerProfile whereUpdatedAt($value)
 */
	class PassengerProfile extends \Eloquent {}
}

namespace App{
/**
 * App\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent {}
}

namespace App{
/**
 * App\Ride
 *
 * @property int $id
 * @property int $company_id
 * @property int $route_id
 * @property int $bus_id
 * @property string $departure_time
 * @property \Illuminate\Support\Carbon|null $ride_date
 * @property string $ride_type
 * @property int $auto_confirm
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Booking[] $bookings
 * @property-read int|null $bookings_count
 * @property-read \App\Bus $bus
 * @property-read \App\EmployeeRide|null $employeeRide
 * @property-read mixed $departure_time_formatted
 * @property-read array $running_days
 * @property-read \App\Route $route
 * @property-read \App\RideSchedule|null $schedule
 * @method static \Illuminate\Database\Eloquent\Builder|Ride active()
 * @method static \Illuminate\Database\Eloquent\Builder|Ride newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ride newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ride query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ride whereAutoConfirm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ride whereBusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ride whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ride whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ride whereDepartureTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ride whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ride whereRideDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ride whereRideType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ride whereRouteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ride whereUpdatedAt($value)
 */
	class Ride extends \Eloquent {}
}

namespace App{
/**
 * App\RideSchedule
 *
 * @property int $id
 * @property int $ride_id
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon|null $end_date
 * @property int $monday
 * @property int $tuesday
 * @property int $wednesday
 * @property int $thursday
 * @property int $friday
 * @property int $saturday
 * @property int $sunday
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Ride $ride
 * @method static \Illuminate\Database\Eloquent\Builder|RideSchedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RideSchedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RideSchedule query()
 * @method static \Illuminate\Database\Eloquent\Builder|RideSchedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RideSchedule whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RideSchedule whereFriday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RideSchedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RideSchedule whereMonday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RideSchedule whereRideId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RideSchedule whereSaturday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RideSchedule whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RideSchedule whereSunday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RideSchedule whereThursday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RideSchedule whereTuesday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RideSchedule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RideSchedule whereWednesday($value)
 */
	class RideSchedule extends \Eloquent {}
}

namespace App{
/**
 * App\Role
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App{
/**
 * App\Route
 *
 * @property int $id
 * @property int $company_id
 * @property string $route_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $first_terminal
 * @property-read mixed $last_terminal
 * @property-read mixed $total_km
 * @property-read mixed $total_time
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Terminal[] $terminals
 * @property-read int|null $terminals_count
 * @method static \Illuminate\Database\Eloquent\Builder|Route newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Route newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Route query()
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereRouteName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereUpdatedAt($value)
 */
	class Route extends \Eloquent {}
}

namespace App{
/**
 * App\Sale
 *
 * @property int $id
 * @property int $booking_id
 * @property float $rate
 * @property float $payment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Booking $booking
 * @method static \Illuminate\Database\Eloquent\Builder|Sale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sale query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale wherePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereUpdatedAt($value)
 */
	class Sale extends \Eloquent {}
}

namespace App{
/**
 * App\Schedule
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule query()
 */
	class Schedule extends \Eloquent {}
}

namespace App{
/**
 * App\Terminal
 *
 * @property int $id
 * @property int $company_id
 * @property string $terminal_name
 * @property string $terminal_address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Route[] $routes
 * @property-read int|null $routes_count
 * @method static \Illuminate\Database\Eloquent\Builder|Terminal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Terminal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Terminal query()
 * @method static \Illuminate\Database\Eloquent\Builder|Terminal searchTerminal($id)
 * @method static \Illuminate\Database\Eloquent\Builder|Terminal whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Terminal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Terminal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Terminal whereTerminalAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Terminal whereTerminalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Terminal whereUpdatedAt($value)
 */
	class Terminal extends \Eloquent {}
}

namespace App{
/**
 * App\TerminalRoute
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TerminalRoute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TerminalRoute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TerminalRoute query()
 */
	class TerminalRoute extends \Eloquent {}
}

namespace App{
/**
 * App\Token
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Token newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Token newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Token query()
 */
	class Token extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property int $active
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Booking[] $bookings
 * @property-read int|null $bookings_count
 * @property-read \App\BusLocation|null $busLocation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\BusCompanyProfile[] $companyProfile
 * @property-read int|null $company_profile_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ConductorHistory[] $conductorHistory
 * @property-read int|null $conductor_history_count
 * @property-read \App\Employee|null $employeeProfile
 * @property-read string $full_name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\PassengerProfile|null $passengerProfile
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Sale[] $sales
 * @property-read int|null $sales_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

