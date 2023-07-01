<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;
use App\Models\Employee;
use App\Models\Department;

class DepartmentWebTest extends TestCase
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

    public function test_department_list() : void
    {
        $response = $this->actingAs($this->user, 'web')
            ->get('/department/list', ["page" => 0]);

        $response->assertStatus(200);
        ob_end_clean();
    }

    public function test_department_create() : void
    {
        $response = $this->actingAs($this->user, 'web')
            ->get('/department/create');

        $response->assertStatus(200);
        ob_end_clean();
    }

    public function test_department_edit() : void
    {
        ob_get_level();
        $url = "/department/edit/" . $this->department->id;
        $response = $this->actingAs($this->user, 'web')
            ->get($url, []);

        $response->assertStatus(200);
        ob_get_contents();
        ob_end_clean();
    }

    public function test_department_save() : void
    {
        ob_start();
        $response = $this->actingAs($this->user, 'web')
            ->post("/department/save", Department::factory()->make()->toArray());

        $response->assertStatus(200);
        ob_get_contents();
        ob_end_clean();
    }

    public function test_department_update() : void
    {
        ob_start();
        $department = Department::factory()->create();
        $response = $this->actingAs($this->user, 'web')
            ->put("/department/update/$department->id", $department->toArray() );

        $response->assertStatus(200);
        ob_get_contents();
        ob_end_clean();
    }

    public function test_department_delete() : void
    {
        ob_start();
        $department = Department::factory()->create();
        $response = $this->actingAs($this->user, 'web')
            ->delete("/department/delete/$department->id");

        $response->assertStatus(200);
        ob_get_contents();
        ob_end_clean();
    }

    public function test_department_restore() : void
    {
        ob_start();
        $department = Department::factory()->create();
        $department->delete();
        $response = $this->actingAs($this->user, 'web')
            ->get("/department/restore/$department->id");

        $response->assertStatus(200);
        ob_get_contents();
        ob_end_clean();
    }
}
