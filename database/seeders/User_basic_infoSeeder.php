<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class User_basic_infoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            'TFHA_alumni_year' => 1982,
            'university_name' => 'Simon Fraser Valley',
            'diploma' => 'Computer Science',
            'short_bio' =>'This is a short bio about who I am and what I am passionate about.This is a short bio about who I am and what I am passionate about.This is a short bio about who I am and what I am passionate about.',
            'place_of_birth' => 'White Rock, BC',
            'birthday' => 'July 18, 1984',
            'gender' => 'Female',
            'profession' => 'Business Development Specialist',
            'ethnicity' => 'Aboriginal, Irish, Canadian',
            'indigenous_identity' => 'Qaipu Mikmaq',
            'languages' => 'English',
            'TFHA_years_in_program' => '2003-2006',
            'total_scholarship_funds' => '$21,000',
        ])
    }
}
