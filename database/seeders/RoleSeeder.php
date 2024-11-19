<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'Administrador']);
        $role2 = Role::create(['name' => 'Usuario']);

        Permission::create(['name' => 'home', 'description' => 'Ver dashboard'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'roles', 'description' => 'Ver listado de roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'roles.create', 'description' => 'Crear roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'roles.edit', 'description' => 'Editar roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'roles.assign-permission', 'description' => 'Asignar permisos al rol'])->syncRoles([$role1]);

        Permission::create(['name' => 'account-yape', 'description' => 'Cuenta de Yape'])->syncRoles([$role1]);
        Permission::create(['name' => 'payment-yape', 'description' => 'Pagos de Yape'])->syncRoles([$role1]);

        Permission::create(['name' => 'users', 'description' => 'Ver listado de usuarios'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.create', 'description' => 'Crear usuarios'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.edit', 'description' => 'Editar usuarios'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.delete', 'description' => 'Eliminar usuarios'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.assign-role', 'description' => 'Asignar roles al usuario'])->syncRoles([$role1]);

        Permission::create(['name' => 'categories', 'description' => 'Ver listado de categorias'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'categories.create', 'description' => 'Crear categorias'])->syncRoles([$role1]);
        Permission::create(['name' => 'categories.edit', 'description' => 'Editar categorias'])->syncRoles([$role1]);
        Permission::create(['name' => 'categories.delete', 'description' => 'Eliminar categorias'])->syncRoles([$role1]);

        Permission::create(['name' => 'articles', 'description' => 'Ver listado de articulos'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'articles.create', 'description' => 'Crear articulos'])->syncRoles([$role1]);
        Permission::create(['name' => 'articles.edit', 'description' => 'Editar articulos'])->syncRoles([$role1]);
        Permission::create(['name' => 'articles.delete', 'description' => 'Eliminar articulos'])->syncRoles([$role1]);
    }
}
