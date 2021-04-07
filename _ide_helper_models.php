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
 * App\Bus
 *
 * @property int $id
 * @property int $bus_no
 * @property string $bus_plate
 * @property int $bus_seat
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Bus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bus query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bus whereBusNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bus whereBusPlate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bus whereBusSeat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bus whereUpdatedAt($value)
 */
	class Bus extends \Eloquent {}
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
 * @property string $route_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Route newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Route newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Route query()
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereRouteName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Route whereUpdatedAt($value)
 */
	class Route extends \Eloquent {}
}

namespace App{
/**
 * App\Schedule
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule query()
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Schedule whereUpdatedAt($value)
 */
	class Schedule extends \Eloquent {}
}

namespace App{
/**
 * App\Terminal
 *
 * @property int $id
 * @property string $terminal_name
 * @property string $terminal_address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Route[] $routes
 * @property-read int|null $routes_count
 * @method static \Illuminate\Database\Eloquent\Builder|Terminal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Terminal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Terminal query()
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
 * @property int $id
 * @property int $route_id
 * @property int $location_id
 * @property int $order
 * @property int $minutes_from_departure
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TerminalRoute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TerminalRoute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TerminalRoute query()
 * @method static \Illuminate\Database\Eloquent\Builder|TerminalRoute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TerminalRoute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TerminalRoute whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TerminalRoute whereMinutesFromDeparture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TerminalRoute whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TerminalRoute whereRouteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TerminalRoute whereUpdatedAt($value)
 */
	class TerminalRoute extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $first_name
 * @property string $last_name
 * @property string|null $middle_name
 * @property string|null $name_extension
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $full_name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNameExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

