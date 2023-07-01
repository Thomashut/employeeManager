<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;
use App\Models\Employee;
use App\Models\Department;

class EmployeeWebTest extends TestCase
{
    use RefreshDatabase;

    protected ?User $user;
    protected ?Employee $employee;
    protected ?Department $department;

    protected function setUp() : void {
        parent::setUp();

        $department = Department::factory()->create();
        $user = User::factory()->for(Employee::Factory()->for($department)->create())->isManager()->create();

        $this->user = $user;
        $this->department = $department;
        $this->employee = $user->Employee;
    }

    protected function tearDown() : void {
        parent::tearDown();

        unset($this->user);
        unset($this->employee);
        unset($this->department);
    }

    public function test_employee_default() : void
    {
        $response = $this->actingAs($this->user, 'web')
            ->get('/');

        $response->assertStatus(200);
        ob_end_clean();
    }

    public function test_employee_dashboard() : void
    {
        $response = $this->actingAs($this->user, 'web')
            ->get('/dashboard');

        $response->assertStatus(200);
    }

    public function test_employee_logout() : void
    {
        $response = $this->actingAs($this->user, 'web')
            ->get('/logout');

        $response->assertStatus(302);
    }

    public function test_employee_login() : void
    {
        $response = $this->actingAs($this->user, 'web')
            ->get('/dashboard');

        $response->assertStatus(200);
    }

    public function test_employee_list() : void
    {
        $response = $this->actingAs($this->user, 'web')
            ->get('/employee/list', ["page" => 0]);

        $response->assertStatus(200);
        ob_end_clean();
    }

    public function test_employee_create() : void
    {
        $response = $this->actingAs($this->user, 'web')
            ->get('/employee/create');

        $response->assertStatus(200);
        ob_end_clean();
    }

    public function test_employee_edit() : void
    {
        ob_start();
        $response = $this->actingAs($this->user, 'web')
            ->get("/employee/edit/$this->employee");

        $response->assertStatus(200);
        ob_get_contents();
        ob_end_clean();
    }

    public function test_employee_save() : void
    {
        ob_start();
        $response = $this->actingAs($this->user, 'web')
            ->post("/employee/save", Employee::factory()->for($this->department)->make()->toArray());

        $response->assertStatus(200);
        ob_get_contents();
        ob_end_clean();
    }

    public function test_employee_update() : void
    {
        ob_start();
        $employee = Employee::factory()->for($this->department)->create();
        $response = $this->actingAs($this->user, 'web')
            ->put("/employee/update/$employee->id", $employee->toArray() );

        $response->assertStatus(200);
        ob_get_contents();
        ob_end_clean();
    }

    public function test_employee_delete() : void
    {
        ob_start();
        $employee = Employee::factory()->for($this->department)->create();
        $response = $this->actingAs($this->user, 'web')
            ->delete("/employee/delete/$employee->id");

        $response->assertStatus(200);
        ob_get_contents();
        ob_end_clean();
    }

    public function test_employee_restore() : void
    {
        ob_start();
        $employee = Employee::factory()->for($this->department)->create();
        $employee->delete();
        $response = $this->actingAs($this->user, 'web')
            ->get("/employee/restore/$employee->id");

        $response->assertStatus(200);
        ob_get_contents();
        ob_end_clean();
    }
}
