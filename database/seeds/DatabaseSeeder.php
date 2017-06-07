<?php

use App\Distribution;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('levels')->insert([
            'lvl' => 'junior',
        ]);
        DB::table('levels')->insert([
            'lvl' => 'middle',
        ]);
        DB::table('levels')->insert([
            'lvl' => 'senior',
        ]);
        //////////////////////////////////

        DB::table('priority_tasks')->insert([
            'priority' => 'minor',
        ]);
        DB::table('priority_tasks')->insert([
            'priority' => 'major',
        ]);
        DB::table('priority_tasks')->insert([
            'priority' => 'bloker',
        ]);
        //////////////////////////////////

        DB::table('specialities')->insert([
            'speciality' => 'front-end',
        ]);
        DB::table('specialities')->insert([
            'speciality' => 'back-end js',
        ]);
        DB::table('specialities')->insert([
            'speciality' => 'back-end php',
        ]);
        DB::table('specialities')->insert([
            'speciality' => 'qa',
        ]);
        DB::table('specialities')->insert([
            'speciality' => 'designer ui',
        ]);
        ////////////////////////////////////

        DB::table('status_tasks')->insert([
            'status' => 'new',
        ]);
        DB::table('status_tasks')->insert([
            'status' => 'indev',
        ]);
        DB::table('status_tasks')->insert([
            'status' => 'inqa',
        ]);
        DB::table('status_tasks')->insert([
            'status' => 'complete',
        ]);
        ////////////////////////////////////

        DB::table('tag_specialities')->insert([
            'tag' => 'PHP7',
        ]);
        DB::table('tag_specialities')->insert([
            'tag' => 'LESS',
        ]);
        DB::table('tag_specialities')->insert([
            'tag' => 'SASS',
        ]);
        DB::table('tag_specialities')->insert([
            'tag' => 'PayPal',
        ]);
        DB::table('tag_specialities')->insert([
            'tag' => 'Angular Js',
        ]);
        DB::table('tag_specialities')->insert([
            'tag' => 'none',
        ]);
        ////////////////////////////////////////

        Distribution::AddWeek(Carbon::now()->addHours(3)->weekOfYear, Carbon::now()->addHours(3)->year);
    }
}
