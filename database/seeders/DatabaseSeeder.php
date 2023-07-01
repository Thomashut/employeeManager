<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Department;
use App\Models\Employee;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $processing = Department::factory()->state(['name' => 'Order Processing', 'description' => 'Order Processing'])->create();
        $sales = Department::factory()->state(['name' => 'Sales', 'description' => 'Sales'])->create();
        $support = Department::factory()->state(['name' => 'Support', 'description' => 'Support'])->create();

        $employees = Employee::factory(5)->for($processing)->has(User::factory())->create();
        $employees->merge(Employee::factory(5)->for($sales)->has(User::factory())->create());

        try {
            Employee::factory()->for($support)->has(User::factory()->isManager()->state([
                'email' => 'test@test.com'
            ]))->create();
        } catch (\Exception $e) {
            echo("The seeder has already been ran. Admin account test@test.com password is password");
        }
    }
}
