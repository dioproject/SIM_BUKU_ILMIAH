<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_user' => $this->faker->numberBetween(-10000, 10000),
            'email' => $this->faker->safeEmail,
            'password' => $this->faker->password,
            'user_role' => $this->faker->randomElement(["ADMIN","EDITOR","WRITER"]),
        ];
    }
}
