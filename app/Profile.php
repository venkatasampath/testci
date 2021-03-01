<?php

/**
 * Profile Model
 *
 * @category   Profile
 * @package    Models
 * @author     Sachin Pawaskar<spawaskar@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'help', 'default_value', 'kind', 'display_type', 'display_values',
        'type', 'group','display_order',
        'created_by', 'updated_by',];

    /**
     * Get all of the orgs that are assigned this profile.
     */
    public function orgs()
    {
        return $this->morphedByMany('App\Org', 'profileable')
            ->withPivot('profile_id', 'profileable_id', 'profileable_type', 'value', 'json_values', 'override', 'created_by', 'updated_by')
            ->withTimestamps();
    }

    /**
     * Get all of the users that are assigned this profile.
     */
    public function users()
    {
        return $this->morphedByMany('App\User', 'profileable')
            ->withPivot('profile_id', 'profileable_id', 'profileable_type', 'value', 'json_values', 'override', 'created_by', 'updated_by')
            ->withTimestamps();
    }
}
