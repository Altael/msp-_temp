<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Geo::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PracticePointsSeeder::class);
        $this->call(PracticeRanksSeeder::class);
        $this->call(AharyaSeeder::class);
        $this->call(AsanasSeeder::class);
        $this->call(DharmacakraSeeder::class);
        $this->call(FullbathSeeder::class);
        $this->call(HalfbathSeeder::class);
        $this->call(PancajaniaSeeder::class);
        $this->call(UpavasaSeeder::class);
        $this->call(FastingsSeeder::class);
        $this->call(SpiritualNamesSeeder::class);
        $this->call(StatusesSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(HistoryEventsSeeder::class);
        $this->call(SadvipraSeeder::class);
    }
}
