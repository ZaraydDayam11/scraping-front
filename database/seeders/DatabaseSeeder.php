<?php

namespace Database\Seeders;

use App\Models\Membership;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        File::deleteDirectory('public/storage/galery');
        File::deleteDirectory('public/storage/yape');
        File::deleteDirectory('public/storage/livewire-tmp');
        File::deleteDirectory('public/storage/profile-photos');
        File::deleteDirectory('public/images');
        File::makeDirectory('public/storage/galery');
        File::makeDirectory('public/storage/yape');
        File::makeDirectory('public/images');
        Storage::deleteDirectory('galery');

        $this->call([
            RoleSeeder::class,
        ]);

        // Crear o buscar el plan 'Free'
        $freeMembership = Membership::firstOrCreate(
            ['plan' => 'Lite'],
            ['precio' => '0', 'cantidad_veces' => 3, 'cantidad_urls' => 1]
        );

        // Crear o buscar el plan 'Premium'
        $premiumMembership = Membership::firstOrCreate(
            ['plan' => 'Standard'],
            ['precio' => '15', 'cantidad_veces' => 10, 'cantidad_urls' => 2] // Ajusta el precio y cantidad_veces según tus necesidades
        );

        // Crear o buscar el plan 'Enterprise'
        $enterpriseMembership = Membership::firstOrCreate(
            ['plan' => 'Ultra'],
            ['precio' => '30', 'cantidad_veces' => 20, 'cantidad_urls' => 5] // Ajusta el precio y cantidad_veces según tus necesidades
        );

        User::create([
            'name' => 'Darwin Condori',
            'dni' => '48591442',
            'membership_id' => $enterpriseMembership->id,
            'email' => 'darwin.condori@gmail.com',
            'password' => bcrypt('12345678')
        ])->assignRole('Administrador');

        User::factory()->create([
            'name' => 'Dyana Pari',
            'email' => 'dyana.zaraid@gmail.com',
            'membership_id' => $freeMembership->id,
        ])->assignRole('Usuario');

        // Crear usuarios adicionales con el rol 'Usuario' y plan 'Free'
        User::factory(5)->create([
            'membership_id' => $freeMembership->id,
        ])->each(function ($user) {
            $user->assignRole('Usuario');
        });

        $this->call(YapeSeeder::class);
    }
}
