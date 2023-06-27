<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subsidiary;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Profession;
use App\Models\Comment;
use App\Models\Appointment;
use App\Models\Language;
use App\Models\Address;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
     

        Address::create(['city' => 'Riga', 'street'=>'Abolu street 4']);
        Address::create(['city' => 'Ventspils', 'street'=>'Ulmana street 88']);
        Address::create(['city' => 'Kekava', 'street'=>'Rudens street 23']);
        Address::create(['city' => 'Madona', 'street'=>'Saules street 234']);

        Profession::create(['name' => 'Cardiologist']);
        Profession::create(['name' => 'Dermatologist']);
        Profession::create(['name' => 'Endocrinologist']);
        Profession::create(['name' => 'Gastroenterologist']);
        Profession::create(['name' => 'Neurologist']);
        Profession::create(['name' => 'Pediatrician']);
        Profession::create(['name' => 'Oncologist']);
        Profession::create(['name' => 'Ophthalmologist']);

        Language::create(['code' => 'RU', 'name'=>'Russian']);
        Language::create(['code' => 'LV', 'name'=>'Latvian']);
        Language::create(['code' => 'EN', 'name'=>'English']);
        Language::create(['code' => 'DE', 'name'=>'German']);
        Language::create(['code' => 'IT', 'name'=>'Italian']);

        $faker = Faker::create();

        for ($i = 0; $i < 3; $i++) {
            User::insert([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => Hash::make('password'), // all users have the same password for test
                'role' => 1,
            ]);
        }

        for ($i = 0; $i < 3; $i++) {
            User::insert([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => Hash::make('password'), // all users have the same password for test
                'role' => 0,
            ]);
        }

        User::insert([
            'name' => 'admin',
            'email' =>'admin@gmail.com',
            'password' => Hash::make('password'), // all users have the same password for test
            'role' => 2,   
        ]);

        $addressId1 = Address::where('city', 'Riga')->where('street', 'Abolu street 4')->value('id');
        $addressId2 = Address::where('city', 'Ventspils')->where('street', 'Ulmana street 88')->value('id');
        $addressId3 = Address::where('city', 'Kekava')->where('street', 'Rudens street 23')->value('id');
        $addressId4 = Address::where('city', 'Madona')->where('street', 'Saules street 234')->value('id');


        Subsidiary::create([
            'naming' => 'MFD Ilguciems',
            'address_id' => $addressId1,
            'manager_id' => 1,
            'email' => 'mfdilg@example.com',
        ]);

        Subsidiary::create([
            'naming' => 'MFD Pardaugava',
            'address_id' => $addressId2,
            'manager_id' => 2,
            'email' => 'mfdpardau@example.com',
        ]);

        Subsidiary::create([
            'naming' => 'MFD Centrs',
            'address_id' => $addressId3,
            'manager_id' => 3,
            'email' => 'mfdcentrs@example.com',
        ]);

        Subsidiary::create([
            'naming' => 'MFD Sarkandaugava',
            'address_id' => $addressId4,
            'manager_id' => 3,
            'email' => 'mfdsaarkan@example.com',
        ]);


        $Cardiologists = Profession::where('name', 'Cardiologist')->value('id');
        $Dermatologists = Profession::where('name', 'Dermatologist')->value('id');
        $Endocrinologists = Profession::where('name', 'Endocrinologist')->value('id');
        $Gastroenterologists = Profession::where('name', 'Gastroenterologist')->value('id');
        $Neurologists = Profession::where('name', 'Neurologist')->value('id');
        $Pediatricians = Profession::where('name', 'Pediatrician')->value('id');
        $Oncologists = Profession::where('name', 'Oncologist')->value('id');
        $Ophthalmologists = Profession::where('name', 'Ophthalmologist')->value('id');

        $subsidiaryId1 = Subsidiary::where('naming', 'MFD Sarkandaugava')->value('id');
        $subsidiaryId2 = Subsidiary::where('naming', 'MFD Centrs')->value('id');
        $subsidiaryId3 = Subsidiary::where('naming', 'MFD Pardaugava')->value('id');
        $subsidiaryId4 = Subsidiary::where('naming', 'MFD Ilguciems')->value('id');


        Doctor::create([
            'name' => 'John Doe',
            'gender' => 'Male',
            'profession_id' => $Cardiologists,
            'subsidiary_id' => $subsidiaryId1,
            'phone' => 12345678,
        ]);

        Doctor::create([
            'name' => 'Jane Smith',
            'gender' => 'Female',
            'profession_id' => $Gastroenterologists,
            'subsidiary_id' => $subsidiaryId2,
            'phone' => 98765432,
        ]);

        Doctor::create([
            'name' => 'Mike Johnson',
            'gender' => 'Male',
            'profession_id' => $Ophthalmologists,
            'subsidiary_id' => $subsidiaryId3,
            'phone' => 45678912,
        ]);

        Doctor::create([
            'name' => 'Carl Ericson',
            'gender' => 'Male',
            'profession_id' => $Endocrinologists,
            'subsidiary_id' => $subsidiaryId3,
            'phone' => 45678912,
        ]);
        
        Doctor::create([
            'name' => 'Emily Anderson',
            'gender' => 'Female',
            'profession_id' => $Gastroenterologists,
            'subsidiary_id' => $subsidiaryId4,
            'phone' => 65432198,
        ]);
        
        Doctor::create([
            'name' => 'Robert Davis',
            'gender' => 'Male',
            'profession_id' => $Neurologists,
            'subsidiary_id' => $subsidiaryId1,
            'phone' => 98712345,
        ]);
        
        Doctor::create([
            'name' => 'Sarah Thompson',
            'gender' => 'Female',
            'profession_id' => $Pediatricians,
            'subsidiary_id' => $subsidiaryId2,
            'phone' => 32165498,
        ]);

        Doctor::create([
            'name' => 'Michael Brown',
            'gender' => 'Male',
            'profession_id' => $Oncologists,
            'subsidiary_id' => $subsidiaryId3,
            'phone' => 98765432,
        ]);
        
        Doctor::create([
            'name' => 'Jennifer Lee',
            'gender' => 'Female',
            'profession_id' => $Ophthalmologists,
            'subsidiary_id' => $subsidiaryId4,
            'phone' => 45678912,
        ]);
        
        Doctor::create([
            'name' => 'David Wilson',
            'gender' => 'Male',
            'profession_id' => $Cardiologists,
            'subsidiary_id' => $subsidiaryId1,
            'phone' => 65432198,
        ]);
        
        Doctor::create([
            'name' => 'Jessica Garcia',
            'gender' => 'Female',
            'profession_id' => $Dermatologists,
            'subsidiary_id' => $subsidiaryId2,
            'phone' => 98712345,
        ]);

        $users = User::pluck('id');
        $doctors = Doctor::pluck('id');
        
        for ($i = 0; $i < 7; $i++) {
            Comment::create([
                'user_id' => $users->random(),
                'doctor_id' => $doctors->random(),
                'text' => 'Database test comment',
            ]);
        }


        for ($i = 0; $i < 7; $i++) {
            $userId = mt_rand(4, 6);
            Appointment::create([
                
                'user_id' => $userId,
                'doctor_id' => $doctors->random(),
                'date' => now()->addDays($i),
                'time' => '10:00',
                'status' => 'waiting',
            ]);
        }

        $currentDateTime = Carbon::now();
        $doctors = Doctor::all();
        $languages = Language::all();

        foreach ($doctors as $doctor) {
            $randomLanguages = $languages->random(rand(1, 3));

            foreach ($randomLanguages as $language) {
                $doctor->languages()->attach($language, [
                    'created_at' => $currentDateTime,
                    'updated_at' => $currentDateTime,
                ]);
            }
        }



      
        














        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    
}

}
