<?php

namespace App\DataFixtures;

use App\Entity\AppUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public static function newUserData(): array
    {
        $faker = Factory::create();
        return [
            AppUser::EMAIL => $faker->email,
            AppUser::PASSWORD => 'pass',
            AppUser::MOBILE_PHONE => $faker->phoneNumber,
            AppUser::FIRST_NAME => $faker->firstName,
            AppUser::LAST_NAME => $faker->lastName,
            AppUser::ABOUT => $faker->text(200)
        ];
    }

    public function load(ObjectManager $manager): void
    {
        //
    }
}
