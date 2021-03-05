<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
        [
            'username' => 'koordinator',
            'password' => bcrypt('koortiftulm'),
        ]);
        
        DB::table('users')->insert([
            'username' => 'admin',
            'password' => bcrypt('admintiftulm'),
        ]);

        $coordinator = User::whereUsername('koordinator')->first();

        $coordinator->roles()->sync(Role::whereRoleName('koordinator')->first()->id);

        $admin = User::whereUsername('admin')->first();

        $admin->roles()->sync(Role::whereRoleName('admin')->first()->id);
    }
}
