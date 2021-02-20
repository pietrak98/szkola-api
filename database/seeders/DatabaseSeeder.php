<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'John DOE';
        $user->email = 'john.doe@email.com';
        $user->password = bcrypt('secret');
        $user->save();
    }
}
