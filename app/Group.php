<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	/**
	 * Get all of the groups for the group.
	 */
	public function belongs()
	{
		return $this->morphToMany('App\Group', 'belong');
	}

	/**
	 * Get all of the groups that are assigned this group.
	 */
	public function groups()
	{
		return $this->morphedByMany('App\Group', 'belong');
	}

	/**
	 * Get all of the categories that are assigned this group.
	 */
	public function categories()
	{
		return $this->morphedByMany('App\Category', 'belong');
	}
}
