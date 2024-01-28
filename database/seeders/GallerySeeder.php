<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gallery::insert([
            [
                'img' => 'gallery1.jpg',
            ],
            [
                'img' => 'gallery2.jpg',
            ],
            [
                'img' => 'gallery3.jpg',
            ],
            [
                'img' => 'gallery4.jpg',
            ],
        ]);
    }
}
