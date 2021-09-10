<?php

namespace Database\Factories;

use App\Models\Ticket;
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
        return [
            "title" => $this->faker->words($this->faker->numberBetween(1, 5),true),
            "description" => $this->faker->paragraphs($this->faker->numberBetween(1, 3),true),
            "due" => $this->faker->dateTimeBetween("now", "+1year"),
            "status" => $this->faker->numberBetween(1, 10),
        ];
    }
}
