<?php 
namespace App\Extensions;

use Illuminate\Auth\EloquentUserProvider;

class AdminUserProvider extends EloquentUserProvider
{
	public function retrieveByCredentials(array $credentials)
	{
		$user = parent::retrieveByCredentials($credentials);
		if ($user !=null) 
		{
			if ($user->email && $user->password) 
			{
				return $user;
			}
		}
		return null;
	}
}