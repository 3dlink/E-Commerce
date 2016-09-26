<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

	/**
     * Get all of the groups for the category.
     */
	public function belongs(){
		return $this->morphToMany('App\Group', 'belong');
	}

	public function items(){
		return $this->belongsToMany('App\Item');
	}
}
