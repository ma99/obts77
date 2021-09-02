<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\User;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');



Artisan::command('create:superadmin', function () {
    $users = User::all();
    if ($users->count()) {
    	foreach ($users as $user) {
    		if ($user->isAdmin()) {
    			$this->info('Admin/ Super Admin already exists!');
    			return;
    		}
    	}
    }

	$phone = $this->ask('What is your phone?');

	$user = User::where('phone', $phone)->first();

	if ($user) {
	   $this->comment("Phone is being used by the following user!");
	   $this->info("Name: {$user->name} ");
	   $this->info("Email: {$user->email}");
	   $this->info("phone: {$user->phone}");

	   if ($this->confirm('Do you wish to grant him Super Admin role?')) {
	   		$user->assign(1);  //roleId
		    $this->info("Super Admin role granted successfully!");
		    return;
	   }
	   return;
	}

	$name = $this->ask('What is your name?');
	$email = $this->ask('What is your email?');
	$password = $this->secret('What is the password?');

 	if ($this->confirm('Do you wish to continue?')) {

 		try {
			$user = User::updateOrCreate(
		        ['phone' => $phone],
		    	[
			        'name' => $name,
			        'email' => $email,
			        'password' => Hash::make($password),
		    	]
			);

			$user->assign(1);  //roleId

		    $this->info("User created successfully with Super Admin role");
		}
		catch(\Exception $e) {
		  echo "Message:  {$e->getMessage()}";
		}    
	}
})->describe('Create Super Admin if not exists');

// php artisan user 1
Artisan::command('user {userId}', function () {
   $userId = $this->argument('userId');	
   $user = User::find($userId);
   if ($user) {
   		$role = $user->roles()->first()->name ?? 'regular user';
	   $this->comment("Here are the infos of User");
	   $this->info("Name: {$user->name} ");
	   $this->info("Email: {$user->email}");
	   $this->info("phone: {$user->phone}");
	   $this->info("role: {$role}");
	   return;   	
   }
   $this->error("Woops! User doesn't exist");
})->describe('Display User Info By ID');