<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Gender;
use App\Models\Religion;
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
            'email' => $this->faker->safeEmail,
            'password' => $this->faker->password,
            'user_role' => $this->faker->randomElement(["ADMIN","EDITOR","AUTHOR"]),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'place_of_birth' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'date_of_birth' => $this->faker->date(),
            'contact' => $this->faker->regexify('[A-Za-z0-9]{30}'),
            'religion_id' => Religion::factory(),
            'gender_id' => Gender::factory(),
        ];
    }
}
