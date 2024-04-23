<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Biodata;

class BiodataFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Biodata::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_biodata' => $this->faker->numberBetween(-10000, 10000),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'place_of_birth' => $this->faker->regexify('[A-Za-z0-9]{25}'),
            'date_of_birth' => $this->faker->date(),
            'religion' => $this->faker->randomElement(["ISLAM","KATOLIK","KRISTEN","HINDU","BUDHA","KHONGHUCU"]),
            'gender' => $this->faker->randomElement(["MAN","WOMAN"]),
            'path_foto' => $this->faker->regexify('[A-Za-z0-9]{50}'),
        ];
    }
}
