<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Role Types
         *
         */
        $RoleItems = [
            [
                'name'        => 'Admin',
                'slug'        => 'admin',
                'description' => 'Admin Role',
                'level'       => 5,
            ],
            [
                'name'        => 'Acarya',
                'slug'        => 'acarya',
                'description' => 'Acarya Role',
                'level'       => 3,
            ],
            [
                'name'        => 'Secretary',
                'slug'        => 'secretary',
                'description' => 'Secretary Role',
                'level'       => 1,
            ],
            [
                'name'        => 'Helper',
                'slug'        => 'helper',
                'description' => 'Helper Role',
                'level'       => 1,
            ],

            [
                'name'        => 'Sadhaka',
                'slug'        => 'sadhaka',
                'description' => 'Sadhaka Role',
                'level'       => 0,
            ],

            [
                'name'        => 'Margii',
                'slug'        => 'margii',
                'description' => 'Margii Role',
                'level'       => 0,
            ],

            [
                'name'        => 'Bhukti Pradhan',
                'slug'        => 'bp',
                'description' => 'Bhukti Pradhan Role',
                'level'       => 0,
            ],

            [
                'name'        => 'Geo',
                'slug'        => 'geo',
                'description' => 'Geo Watcher Role',
                'level'       => 0,
            ],

            [
                'name'        => 'Geo Editor',
                'slug'        => 'geo-editor',
                'description' => 'Geo Editor Role',
                'level'       => 0,
            ],

            [
                'name'        => 'Trustee',
                'slug'        => 'trustee',
                'description' => 'Trustee Role',
                'level'       => 0,
            ],

            [
                'name'        => 'Diary',
                'slug'        => 'diary',
                'description' => 'Diary Editor Role',
                'level'       => 0,
            ],

            [
                'name'        => 'Watcher',
                'slug'        => 'watcher',
                'description' => 'All Users Watcher Role',
                'level'       => 0,
            ],

            [
                'name'        => 'Blogger',
                'slug'        => 'blogger',
                'description' => 'Blogger... Is that difficult?',
                'level'       => 0,
            ],

            [
                'name'        => 'Singer',
                'slug'        => 'singer',
                'description' => 'Singer. The one who deals with songs.',
                'level'       => 0,
            ],
        ];

        /*
         * Add Role Items
         *
         */
        foreach ($RoleItems as $RoleItem) {
            $newRoleItem = config('roles.models.role')::where('slug', '=', $RoleItem['slug'])->first();
            if ($newRoleItem === null) {
                $newRoleItem = config('roles.models.role')::create([
                    'name'          => $RoleItem['name'],
                    'slug'          => $RoleItem['slug'],
                    'description'   => $RoleItem['description'],
                    'level'         => $RoleItem['level'],
                ]);
            }
        }
    }
}
