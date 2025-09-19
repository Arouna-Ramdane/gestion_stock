<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole  = Role::firstOrCreate(['name' => 'user']);

        $permissions = [
            // Personnes
            'add-personne',
            'edit-personne',
            'view-personne',
            'delete-personne',

            // Utilisateurs
            'add-user',
            'edit-user',
            'view-user',
            'delete-user',

            // Clients
            'add-client',
            'edit-client',
            'view-client',
            'delete-client',

            // Produits
            'add-produit',
            'edit-produit',
            'view-produit',
            'delete-produit',

            // Commandes
            'add-commande',
            'edit-commande',
            'view-commande',
            'delete-commande',

            // Lignes de commandes
            'add-lignecommande',
            'edit-lignecommande',
            'view-lignecommande',
            'delete-lignecommande',

            // Depenses
            'add-depense',
            'edit-depense',
            'view-depense',
            'delete-depense',

            //Autres
            'view-totalJournalier',
            'view-allCommande'
        ];

        foreach ($permissions as $perm) {
            $permission = Permission::firstOrCreate(['name' => $perm]);
            $adminRole->givePermissionTo($permission);
        }

        $userPermissions = [
            'view-personne', 'add-personne',
            'add-client', 'edit-client', 'delete-client',
            'view-produit',
            'view-commande', 'add-commande', 'edit-commande',
            'view-lignecommande', 'add-lignecommande', 'edit-lignecommande',
            'add-depense', 'view-depense', 'edit-depense', 'delete-depense',
        ];

        $userRole->syncPermissions($userPermissions);
    }
}
