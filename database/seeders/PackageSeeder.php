<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Zenith Package',
                'slug' => 'zenith-package',
                'category' => 'Zenith',
                'price' => 10500,
                'description' => 'Premium package for upgraded members.',
                'sort_order' => 1,
            ],
        ];

        foreach ($packages as $package) {
            Package::updateOrCreate(['slug' => $package['slug']], $package);
        }
    }
}
