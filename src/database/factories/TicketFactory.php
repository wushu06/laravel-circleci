<?php

namespace Database\Factories;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $os = [
            'Mac',
            'Windows',
            'Linux'
        ];
        $rand = array_rand($os);

        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'address' => $this->faker->address(),
            'degree' => $this->faker->text(20),
            'uni_year' => (string) Carbon::now()->year,
            'os' => $os[$rand],
            'issue' => $this->faker->paragraph(),
            'status' => rand(0,1)
        ];
    }
}
