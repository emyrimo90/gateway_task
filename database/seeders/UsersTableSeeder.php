<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $permissions = Permission::where('guard_name', 'sanctum')->get();
        $role = Role::whereName(Role::DEFAULT_ROLE_SUPER_ADMIN)->first();
        if($role){
            $role->givePermissionTo($permissions);
        }
        $user = User::where('email' , 'admin@email.com')->first();
        if (!$user){
            $user = User::create([
                'name' => 'Super Admin',
                'email' => 'admin@email.com',
                'phone' => '01011279823',
                'password' => 123456
            ]);
        }
        $user->assignRole($role);
    }
}
