<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Event;
use App\Models\Event_employee;
use App\Models\Event_photo;
use App\Models\Event_requirment;
use App\Models\Event_section;
use App\Models\Interst;
use App\Models\Organization;
use App\Models\Organization_section;
use App\Models\Organization_speaker;
use App\Models\Speaker;
use App\Models\Speaker_experience;
use App\Models\User;
use App\Models\User_Event;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->has(Interst::factory(2))->create();
        Organization::factory(4)->create();
        Event::factory(5)
            ->has(Event_employee::factory(4))
            ->has(Event_photo::factory(3))
            ->has(Event_requirment::factory(5))
            ->has(Event_section::factory(3))
            ->has(
                Speaker::factory(3)
                    ->has(Speaker_experience::factory(3))
            )
            ->create();
        Organization::factory(5)
            ->has(Organization_section::factory(4))
            ->has(Organization_speaker::factory(4))
            ->create();
        Admin::factory(4)->create();
        User_Event::factory(20)->create();



































        // User::factory(10)->create();
        // User::factory(2)->has(Interst::factory(3))->create();
        // Admin::factory(4)->create();
        // Interst::factory(3)->create();
    }
}