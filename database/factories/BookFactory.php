<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\Category;
use App\Models\Citation;
use App\Models\Manuscript;
use App\Models\Review;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => Category::factory(),
            'manuscript_id' => Manuscript::factory(),
            'citation_id' => Citation::factory(),
            'review_id' => Review::factory(),
        ];
    }
}
