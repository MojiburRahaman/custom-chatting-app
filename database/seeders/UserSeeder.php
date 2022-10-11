<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        foreach(range(1,15) as $index){
            $title =  $faker->text(15);
            $company = User::create([
                'name' => $title,
                'slug' => str::slug($title),
                'email' => $faker->email(),
                'password' =>bcrypt(12345678),
            ]);
        }
    }
}
