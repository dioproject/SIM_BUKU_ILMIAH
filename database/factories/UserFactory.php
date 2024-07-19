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
            'name' => $this->faker->name,
            'username' => $this->faker->userName,
            'email' => $this->faker->safeEmail,
            'password' => $this->faker->password,
            'contact' => $this->faker->regexify('[A-Za-z0-9]{30}'),
            'user_role' => $this->faker->randomElement(["ADMIN","REVIEWER","AUTHOR"]),
        ];
    }
}
