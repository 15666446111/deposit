<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('users')->insert([
            'username'  => '15666446111',
            'name'      => 'Gong Ke',
            'email'     => '755969423@qq.com',
            'password'  =>  Hash::make('123456'),
            'ismanage'  =>  '1'
        ]);
    }
}
