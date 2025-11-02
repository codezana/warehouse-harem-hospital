<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([

            //product
            ['page' => 'Product', 'Premission' => 'View', 'name' => 'View Product', 'description' => 'View product Permission'],
            ['page' => 'Product', 'Premission' => 'Create', 'name' => 'Create Product', 'description' => 'Create product Permission'],
            ['page' => 'Product', 'Premission' => 'Edit', 'name' => 'Edit Product', 'description' => 'edit product Permission'],
            ['page' => 'Product', 'Premission' => 'Delete', 'name' => 'Delete Product', 'description' => 'delete product Permission'],
            ['page' => 'Product', 'Premission' => 'Select all', 'name' => 'Select all Product', 'description' => 'select_all product Permission'],

            //Sales
            ['page' => 'Sales', 'Premission' => 'View', 'name' => 'View Sales', 'description' => 'View sales Permission'],
            ['page' => 'Sales', 'Premission' => 'Create', 'name' => 'Create Sales', 'description' => 'Create sales Permission'],
            ['page' => 'Sales', 'Premission' => 'Edit', 'name' => 'Edit Sales', 'description' => 'edit sales Permission'],
            ['page' => 'Sales', 'Premission' => 'Delete', 'name' => 'Delete Sales', 'description' => 'delete sales Permission'],
            ['page' => 'Sales', 'Premission' => 'Select all', 'name' => 'Select all Sales', 'description' => 'select_all sales Permission'],

            //POS
            ['page' => 'POS', 'Premission' => 'View', 'name' => 'View POS', 'description' => 'View POS Permission'],
            ['page' => 'POS', 'Premission' => 'Create', 'name' => 'Create POS', 'description' => 'Create POS Permission'],
            ['page' => 'POS', 'Premission' => 'Edit', 'name' => 'Edit POS', 'description' => 'edit POS Permission'],
            ['page' => 'POS', 'Premission' => 'Delete', 'name' => 'Delete POS', 'description' => 'delete POS Permission'],
            ['page' => 'POS', 'Premission' => 'Select all', 'name' => 'Select all POS', 'description' => 'select_all POS Permission'],

            //Request
            ['page' => 'Request', 'Premission' => 'View', 'name' => 'View Request', 'description' => 'View Request Permission'],
            ['page' => 'Request', 'Premission' => 'Create', 'name' => 'Create Request', 'description' => 'Create Request Permission'],
            ['page' => 'Request', 'Premission' => 'Edit', 'name' => 'Edit Request', 'description' => 'edit Request Permission'],
            ['page' => 'Request', 'Premission' => 'Delete', 'name' => 'Delete Request', 'description' => 'delete Request Permission'],
            ['page' => 'Request', 'Premission' => 'Select all', 'name' => 'Select all Request', 'description' => 'select_all Request Permission'],

            //Notification
            ['page' => 'Notification', 'Premission' => 'View', 'name' => 'View Notification', 'description' => 'View Notification Permission'],
            ['page' => 'Notification', 'Premission' => 'Create', 'name' => 'Create Notification', 'description' => 'Create Notification Permission'],
            ['page' => 'Notification', 'Premission' => 'Edit', 'name' => 'Edit Notification', 'description' => 'edit Notification Permission'],
            ['page' => 'Notification', 'Premission' => 'Delete', 'name' => 'Delete Notification', 'description' => 'delete Notification Permission'],
            ['page' => 'Notification', 'Premission' => 'Select all', 'name' => 'Select all Notification', 'description' => 'select_all Notification Permission'],

            //Purchase
            ['page' => 'Purchase', 'Premission' => 'View', 'name' => 'View Purchase', 'description' => 'View purchase Permission'],
            ['page' => 'Purchase', 'Premission' => 'Create', 'name' => 'Create Purchase', 'description' => 'Create purchase Permission'],
            ['page' => 'Purchase', 'Premission' => 'Edit', 'name' => 'Edit Purchase', 'description' => 'edit purchase Permission'],
            ['page' => 'Purchase', 'Premission' => 'Delete', 'name' => 'Delete Purchase', 'description' => 'delete purchase Permission'],
            ['page' => 'Purchase', 'Premission' => 'Select all', 'name' => 'Select all Purchase', 'description' => 'select_all purchase Permission'],
            //Expenses
            ['page' => 'Expenses', 'Premission' => 'View', 'name' => 'View Expenses', 'description' => 'View expenses Permission'],
            ['page' => 'Expenses', 'Premission' => 'Create', 'name' => 'Create Expenses', 'description' => 'Create expenses Permission'],
            ['page' => 'Expenses', 'Premission' => 'Edit', 'name' => 'Edit Expenses', 'description' => 'edit expenses Permission'],
            ['page' => 'Expenses', 'Premission' => 'Delete', 'name' => 'Delete Expenses', 'description' => 'delete expenses Permission'],
            ['page' => 'Expenses', 'Premission' => 'Select all', 'name' => 'Select all Expenses', 'description' => 'select_all expenses Permission'],
            //Invoices
            ['page' => 'Invoices', 'Premission' => 'View', 'name' => 'View Invoices', 'description' => 'View Invoices Permission'],
            ['page' => 'Invoices', 'Premission' => 'Create', 'name' => 'Create Invoices', 'description' => 'Create Invoices Permission'],
            ['page' => 'Invoices', 'Premission' => 'Edit', 'name' => 'Edit Invoices', 'description' => 'edit Invoices Permission'],
            ['page' => 'Invoices', 'Premission' => 'Delete', 'name' => 'Delete Invoices', 'description' => 'delete Invoices Permission'],
            ['page' => 'Invoices', 'Premission' => 'Select all', 'name' => 'Select all Invoices', 'description' => 'select_all Invoices Permission'],
            //Return
            ['page' => 'Return', 'Premission' => 'View', 'name' => 'View Return', 'description' => 'View Return Permission'],
            ['page' => 'Return', 'Premission' => 'Create', 'name' => 'Create Return', 'description' => 'Create Return Permission'],
            ['page' => 'Return', 'Premission' => 'Edit', 'name' => 'Edit Return', 'description' => 'edit Return Permission'],
            ['page' => 'Return', 'Premission' => 'Delete', 'name' => 'Delete Return', 'description' => 'delete Return Permission'],
            ['page' => 'Return', 'Premission' => 'Select all', 'name' => 'Select all Return', 'description' => 'select_all Return Permission'],
            //Supplier
            ['page' => 'Supplier', 'Premission' => 'View', 'name' => 'View Supplier', 'description' => 'View Supplier Permission'],
            ['page' => 'Supplier', 'Premission' => 'Create', 'name' => 'Create Supplier', 'description' => 'Create Supplier Permission'],
            ['page' => 'Supplier', 'Premission' => 'Edit', 'name' => 'Edit Supplier', 'description' => 'edit Supplier Permission'],
            ['page' => 'Supplier', 'Premission' => 'Delete', 'name' => 'Delete Supplier', 'description' => 'delete Supplier Permission'],
            ['page' => 'Supplier', 'Premission' => 'Select all', 'name' => 'Select all Supplier', 'description' => 'select_all Supplier Permission'],
            //Reports
            ['page' => 'Reports', 'Premission' => 'View', 'name' => 'View Reports', 'description' => 'View Reports Permission'],
            ['page' => 'Reports', 'Premission' => 'Create', 'name' => 'Create Reports', 'description' => 'Create Reports Permission'],
            ['page' => 'Reports', 'Premission' => 'Edit', 'name' => 'Edit Reports', 'description' => 'edit Reports Permission'],
            ['page' => 'Reports', 'Premission' => 'Delete', 'name' => 'Delete Reports', 'description' => 'delete Reports Permission'],
            ['page' => 'Reports', 'Premission' => 'Select all', 'name' => 'Select all Reports', 'description' => 'select_all Reports Permission'],
            //User Management
            ['page' => 'User Management', 'Premission' => 'View', 'name' => 'View User Management', 'description' => 'View User Management Permission'],
            ['page' => 'User Management', 'Premission' => 'Create', 'name' => 'Create User Management', 'description' => 'Create User Management Permission'],
            ['page' => 'User Management', 'Premission' => 'Edit', 'name' => 'Edit User Management', 'description' => 'edit User Management Permission'],
            ['page' => 'User Management', 'Premission' => 'Delete', 'name' => 'Delete User Management', 'description' => 'delete User Management Permission'],
            ['page' => 'User Management', 'Premission' => 'Select all', 'name' => 'Select all User Management', 'description' => 'select_all User Management Permission'],
            //Premission
            ['page' => 'Premission', 'Premission' => 'View', 'name' => 'View Premission', 'description' => 'View Premission Permission'],
            ['page' => 'Premission', 'Premission' => 'Create', 'name' => 'Create Premission', 'description' => 'Create Premission Permission'],
            ['page' => 'Premission', 'Premission' => 'Edit', 'name' => 'Edit Premission', 'description' => 'edit Premission Permission'],
            ['page' => 'Premission', 'Premission' => 'Delete', 'name' => 'Delete Premission', 'description' => 'delete Premission Permission'],
            ['page' => 'Premission', 'Premission' => 'Select all', 'name' => 'Select all Premission', 'description' => 'select_all Premission Permission'],
            //Application
            ['page' => 'Application', 'Premission' => 'View', 'name' => 'View Application', 'description' => 'View Application Permission'],
            ['page' => 'Application', 'Premission' => 'Create', 'name' => 'Create Application', 'description' => 'Create Application Permission'],
            ['page' => 'Application', 'Premission' => 'Edit', 'name' => 'Edit Application', 'description' => 'edit Application Permission'],
            ['page' => 'Application', 'Premission' => 'Delete', 'name' => 'Delete Application', 'description' => 'delete Application Permission'],
            ['page' => 'Application', 'Premission' => 'Select all', 'name' => 'Select all Application', 'description' => 'select_all Application Permission'],
            //Customer
            ['page' => 'Customer', 'Premission' => 'View', 'name' => 'View Customer', 'description' => 'View Customer Permission'],
            ['page' => 'Customer', 'Premission' => 'Create', 'name' => 'Create Customer', 'description' => 'Create Customer Permission'],
            ['page' => 'Customer', 'Premission' => 'Edit', 'name' => 'Edit Customer', 'description' => 'edit Customer Permission'],
            ['page' => 'Customer', 'Premission' => 'Delete', 'name' => 'Delete Customer', 'description' => 'delete Customer Permission'],
            ['page' => 'Customer', 'Premission' => 'Select all', 'name' => 'Select all Customer', 'description' => 'select_all Customer Permission'],
            //ModelChange
            ['page' => 'ModelChange', 'Premission' => 'View', 'name' => 'View ModelChange', 'description' => 'View ModelChange Permission'],


        ]);
    }
}
