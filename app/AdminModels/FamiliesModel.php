<?php

namespace App\AdminModels;

use Illuminate\Database\Eloquent\Model;

class FamiliesModel extends Model
{
    protected $rules = [
    	'email' => 'sometimes|email|unique:users'
	];
}
