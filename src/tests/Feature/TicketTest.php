<?php

namespace Tests\Feature;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function it_can_display_tickets()
    {
        $name = 'Noureddine';
        Ticket::factory()->create([
            'first_name' => $name
        ]);
        $response =  $this->get('/');
        $response->assertStatus(200);
        $this->get('/api/tickets')->assertSee($name);
    }

    /** @test **/
    public function it_can_add_a_ticket()
    {
        $faker = \Faker\Factory::create();
        $name = $faker->firstName();
        $data = [
            'first_name' => $name,
            'last_name' => $faker->lastName(),
            'address' => $faker->address(),
            'degree' => $faker->text(),
            'uni_year' => (string) Carbon::now()->year,
            'os' => 'Mac',
            'issue' => $faker->paragraph()
        ];
        $this->json('POST', '/api/tickets', $data)
            ->assertStatus(200);
        $this->get('/api/tickets')->assertSee($name);
    }

    /** @test **/
    public function it_can_delete_a_ticket()
    {
        $name = 'Noureddine';
        $ticket = Ticket::factory()->create([
            'first_name' => $name
        ]);
        $this->delete('/tickets/'.$ticket->id);
        $this->assertDatabaseMissing('tickets', $ticket->toArray());
    }
}
