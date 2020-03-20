<?php

use App\Models\Admin;

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

Artisan::command('add:admin {--name= : The admin name} {--email= : the admin email}', function () {
    $name = trim($this->option('name'));
    while(!$name)
    {
        $name = $this->ask('What is the admin name ?');
        if (trim($name))
        {
            break;
        }
        $this->error('You must provide name for your admin');
    }

    $email = trim($this->option('email'));
    while(!$email)
    {
        $email = $this->ask('What is the admin email ?');
        if (trim($email))
        {
            break;
        }
        $this->error('You must provide email for your admin');
    }

    while (true)
    {
        $password = $this->secret('What is the admin password ?');
        $passwordConfirmation = $this->secret('Please retype the same password');
        if ($password === $passwordConfirmation) {
            break;
        }
        $this->error('Password and password confirmation is not the same');
    }

    Admin::create([
        'name' => $name,
        'email' => $email,
        'password' => Hash::make($password),
    ]);

    $this->info('Admin created successfully');
})->describe('Insert new application administrator');
