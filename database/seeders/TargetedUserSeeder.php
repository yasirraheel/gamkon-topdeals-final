<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class TargetedUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            'United States' => 'en_US',
            'United Kingdom' => 'en_GB',
            'Pakistan' => 'en_PK',
            'India' => 'en_IN',
            'United Arab Emirates' => 'en_US', // diverse population, en_US is safe default for names
            'Saudi Arabia' => 'ar_SA',
        ];

        $fakerDefault = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            $countryName = array_rand($countries);
            $locale = $countries[$countryName];
            
            // Create faker instance for specific locale
            try {
                $faker = Faker::create($locale);
            } catch (\Exception $e) {
                $faker = $fakerDefault;
            }

            // Ensure unique email and username
            $email = $faker->unique()->safeEmail();
            $username = $faker->unique()->userName();
            
            // Fallback for some locales that might produce non-latin characters for usernames if strict requirements exist, 
            // but standard User model usually handles UTF8. 
            // However, let's keep username simple (ascii) just in case, or allow it. 
            // For now, I'll trust Faker.
            
            // If the locale is Arabic, names might be in Arabic. 
            // If the system expects English names, this might be an issue.
            // The user asked for "real names", so local script is probably best.
            // But username/email should probably be latin characters.
            
            // Re-generating username/email with en_US to ensure login compatibility if system has restrictions
            $fakerAuth = Faker::create('en_US');
            $username = $fakerAuth->unique()->userName() . rand(100, 999);
            $email = $fakerAuth->unique()->safeEmail();

            User::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'username' => $username,
                'email' => $email,
                'phone' => $faker->phoneNumber,
                'country' => $countryName,
                'city' => $faker->city,
                'zip_code' => $faker->postcode,
                'address' => $faker->address,
                'password' => Hash::make('password'), // Default password
                'status' => true,
                'email_verified_at' => now(),
                'user_type' => 'buyer', // Default to buyer
                'balance' => $faker->randomFloat(2, 0, 1000),
            ]);
        }
    }
}
