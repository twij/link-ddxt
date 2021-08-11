<?php

namespace Database\Factories;

use App\Domain\URLRedirect\URLRedirect;
use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class URLRedirectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = URLRedirect::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'token' => Str::random(5),
            'url' => $this->faker->url(),
            'user_id' => null,
            'hits' => $this->faker->randomElement([
                0,
                rand(1, 10000)
            ]),
            'delete_at' => $this->faker->randomElement([
                null,
                Carbon::now()->addDays(rand(1, 365))
            ]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
