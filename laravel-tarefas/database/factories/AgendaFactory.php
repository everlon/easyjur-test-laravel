<?php

namespace Database\Factories;

use App\Models\Agenda;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgendaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Agenda::class;

    public function definition()
    {
        return [
            "nome" => $this->faker->colorName,
            "descricao" => $this->faker->text,
            "user_id" => 53,
        ];
    }
}
