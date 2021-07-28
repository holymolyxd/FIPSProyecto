<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use \Freshwork\ChileanBundle\Rut;
use App\Models\Role;

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
        $rut = $this->rut();
        $name = $this->faker->unique()->firstName();
        $lastname = $this->faker->lastName();
        $domain = '@inacapmail.cl';
        $autoIncrement = $this->autoIncrement();
        $autoIncrement->next();

        $user = [
            'rut' => $rut,
            'name' => $name,
            'email' => $name.'.'.$lastname.$autoIncrement->current().$domain,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            ];
        return $user;
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
    function autoIncrement()
    {
        for($id=0; $id<=100; $id++)
        {
            if($id = 1 or $id = 0):
                yield '';
            elseif($id = 2 or $id = 3 or $id = 4 or $id = 5 or $id = 6
                or $id = 7 or $id = 8 or $id = 9):
                yield '0'.$id;
            else:
                yield $id;
            endif;
        }
    }

    function rut()
    {
    //We loop 100 times
        for($i = 0; $i < 10; $i++)
        {
            //generate random number between 1.000.000 and 25.000.000
            $random_number = rand(1000000, 25000000);

            //We create a new RUT wihtout verification number (the second paramenter of Rut constructor)
            $rut = new Rut($random_number);
            return Rut::parse($rut->fix())->format(Rut::FORMAT_ESCAPED);
        }
    }
}
