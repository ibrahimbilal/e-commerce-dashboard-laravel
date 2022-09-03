<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

		$sections = [
			'dashboard',
			'products',
			'attributes',
			'reviews',
			'categories',
			'tags',
			'discounts',
			'customers',
			'orders',
			'invoices',
			'analytics',
			'marketing',
			'users',
			'roles',
			'gallery',
			'languages',
			'general_settings',
			'theme_settings',
			'store_settings',
			'currencies_settings',
			'emails_settings',
			'payment_settings',
		];

		$permissions = [];
		foreach ($sections as $section) {
			$permissions[] = 'view ' . $section;
			if ( !in_array($section, ['dashboard',
										'analytics',
										'marketing',
										'roles',
										'general_settings',
										'theme_settings',
										'store_settings',
										'currencies_settings',
										'emails_settings',
										'payment_settings',
										'imports',
										'exports',
									]) ) {
				$permissions[] = 'add ' . $section;
				$permissions[] = 'edit ' . $section;
				$permissions[] = 'delete ' . $section;
				$permissions[] = 'permanently_delete ' . $section;
				$permissions[] = 'restore ' . $section;
			}

			if ( in_array($section, ['general_settings',
									'theme_settings',
									'store_settings',
									'currencies_settings',
									'emails_settings',
									'payment_settings']) ) {
				$permissions[] = 'edit ' . $section;
			}

			if ( $section == 'roles' ) {
				$permissions[] = 'add ' . $section;
				$permissions[] = 'edit ' . $section;
				$permissions[] = 'permanently_delete ' . $section;
			}
		}

		$permissions[] = 'imports';
		$permissions[] = 'exports';

		// dd($permissions);

		foreach( $permissions as $permission ) {
			Permission::create(['name' => $permission]);
		}
    }
}
