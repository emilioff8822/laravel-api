<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['Front End', 'Back End', 'Design', 'UX', 'Laravel', 'VueJs'];

        foreach($data as $tag) {
            // Controllo se il tag esiste già nel database
            if (!Tag::where('name', $tag)->first()) {
                $new_tag = new Tag();
                $new_tag->name = $tag;
                $new_tag->slug = Str::slug($tag , '-');
                $new_tag->save();
            }
        }
    }
}