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
			'gallary',
			'languages',
			'general settings',
			'theme settings',
			'store settings',
			'currencies settings',
			'emails settings',
			'payment settings',
		];

		$permissions = [];
		foreach ($sections as $section) {
			$permissions[] = 'view ' . $section;
			if ( !in_array($section, ['dashboard',
										'analytics',
										'marketing',
										'general settings',
										'theme settings',
										'store settings',
										'currencies settings',
										'emails settings',
										'payment settings',
										'imports',
										'exports',
									]) ) {
				$permissions[] = 'edit ' . $section;
				$permissions[] = 'update ' . $section;
				$permissions[] = 'delete ' . $section;
				$permissions[] = 'soft delete ' . $section;
				$permissions[] = 'restore ' . $section;
			}

			if ( in_array($section, ['general settings',
									'theme settings',
									'store settings',
									'currencies settings',
									'emails settings',
									'payment settings']) ) {
				$permissions[] = 'update ' . $section;
			}
		}

		$permissions[] = 'imports';
		$permissions[] = 'exports';

		foreach( $permissions as $permission ) {
			Permission::create(['name' => $permission]);
		}
    }
}
