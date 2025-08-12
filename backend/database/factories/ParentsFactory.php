<?php

namespace Database\Factories;

use App\Models\Parents;
use App\Models\Purpose;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // di ParentsFactory.php

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'student_name' => $this->faker->name,
            'rayon' => $this->faker->randomElement(['A1', 'B2', 'C1', 'D3']),
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'signature_path' => 'uploads/signature_parent/' . $this->faker->lexify('????') . '.png',
        ];
    }

    public function withPurpose(string $purposeText = null)
    {
        return $this->has(
            Purpose::factory()->state(function () use ($purposeText) {
                return [
                    'purpose' => $purposeText ?? $this->faker->sentence,
                    'guest_type' => Parents::class,
                ];
            }),
            'purposes'
        );
    }

}
