<?php

use Illuminate\Database\Seeder;

class TemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('templates')->insert([
            'name' => 'article'
        ]);

        DB::table('templates')->insert([
            'name' => 'media'
        ]);
    }
}
