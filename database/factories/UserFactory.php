<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
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

    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->safeEmail,
            'password' => $this->static::$password ??= Hash::make('password'),
            'user_role' => $this->faker->randomElement(["ADMIN","EDITOR","AUTHOR"]),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'place_of_birth' => $this->faker->regexify('[A-Za-z0-9]{25}'),
            'date_of_birth' => $this->faker->date(),
            'religion' => $this->faker->randomElement(["ISLAM","KATOLIK","KRISTEN","HINDU","BUDHA","KHONGHUCU"]),
            'gender' => $this->faker->randomElement(["MAN","WOMAN"]),
            'path_foto' => $this->faker->regexify('[A-Za-z0-9]{100}'),
        ];
    }
}
