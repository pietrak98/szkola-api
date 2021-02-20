<?php
namespace Database\Seeders;

use App\Models\ClassSchool;
use Illuminate\Database\Seeder;

class ClassesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach ([1, 2, 3] as $number) {
            foreach (['a', 'b', 'c'] as $liter) {
                $cl = new ClassSchool();
                $cl->name = $number . $liter;
                $cl->save();
            }
        }
    }
}
