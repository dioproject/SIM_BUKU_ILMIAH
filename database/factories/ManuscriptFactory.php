<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Citation;
use App\Models\Manuscript;
use App\Models\User;

class ManuscriptFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Manuscript::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'abstract' => $this->faker->text,
            'fill' => $this->faker->text,
            'path_foto' => $this->faker->regexify('[A-Za-z0-9]{200}'),
            'citation_id' => Citation::factory(),
            'author_id' => User::factory(),
        ];
    }
}
