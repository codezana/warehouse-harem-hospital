<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InsertControlller extends Controller
{
    //Home Page

    public function home()
    {

        $productPermissions = Permission::where('page', 'Product')->get();
        $salesPermissions = Permission::where('page', 'Sales')->get();
        $posPermissions = Permission::where('page', 'POS')->get();
        $requestPermissions = Permission::where('page', 'Request')->get();

        $purchasePermissions = Permission::where('page', 'Purchase')->get();
        $notificationPermissions = Permission::where('page', 'Notification')->get();

        $invoicesPermissions = Permission::where('page', 'Invoices')->get();
        $returnPermissions = Permission::where('page', 'Return')->get();
        $supplierPermissions = Permission::where('page', 'Supplier')->get();
        $reportsPermissions = Permission::where('page', 'Reports')->get();

        $applicationPermissions = Permission::where('page', 'Application')->get();
        $customerPermissions = Permission::where('page', 'customer')->get();
        $modelChangePermissions = Permission::where('page', 'ModelChange')->get();
        $userManagementPermissions = Permission::where('page', 'User Management')->get();

        $permissions = Permission::where('page', 'Premission')->get();

        return view('Settings.createpermission', compact(
            'productPermissions',
            'salesPermissions',
            'posPermissions',
            'requestPermissions',
            'purchasePermissions',
            'notificationPermissions',
            'invoicesPermissions',
            'returnPermissions',
            'applicationPermissions',
            'customerPermissions',
            'reportsPermissions',
            'supplierPermissions',
            'modelChangePermissions',
            'userManagementPermissions',
            'permissions'
        ));
    }

    public function checkRole(Request $request)
    {
        // Retrieve the email from the request
        $name = $request->input('rolename');
   
        // Check if the email exists in the database
        $exists = Role::where('name', $name)->exists();

        // Return a JSON response indicating whether the email exists
        return response()->json(['exists' => $exists]);
    }
    //create Role and premission
    public function storeRole(Request $request)
    {
 
  
        $role = Role::create([
            'name' => $request->input('rolename'),
            'description' => $request->input('description'),
        ]);

        if ($request->has('product_permissions')) {
            $productPermissions = Permission::whereIn('name', $request->input('product_permissions'))->get();
            $role->permissions()->attach($productPermissions);
        }

        if ($request->has('sales_permissions')) {
            $salesPermissions = Permission::whereIn('name', $request->input('sales_permissions'))->get();
            $role->permissions()->attach($salesPermissions);
        }
        if ($request->has('pos_permissions')) {
            $posPermissions = Permission::whereIn('name', $request->input('pos_permissions'))->get();
            $role->permissions()->attach($posPermissions);
        }    if ($request->has('request_permissions')) {
            $requestPermissions = Permission::whereIn('name', $request->input('request_permissions'))->get();
            $role->permissions()->attach($requestPermissions);
        }

        if ($request->has('purchase_permissions')) {
            $purchasePermissions = Permission::whereIn('name', $request->input('purchase_permissions'))->get();
            $role->permissions()->attach($purchasePermissions);
        }

        if ($request->has('notification_permissions')) {
            $notificationPermissions = Permission::whereIn('name', $request->input('notification_permissions'))->get();
            $role->permissions()->attach($notificationPermissions);
        }
        if ($request->has('invoices_permissions')) {
            $invoicesPermissions = Permission::whereIn('name', $request->input('invoices_permissions'))->get();
            $role->permissions()->attach($invoicesPermissions);
        }

        if ($request->has('return_permissions')) {
            $returnPermissions = Permission::whereIn('name', $request->input('return_permissions'))->get();
            $role->permissions()->attach($returnPermissions);
        }
        if ($request->has('supplier_permissions')) {
            $supplierPermissions = Permission::whereIn('name', $request->input('supplier_permissions'))->get();
            $role->permissions()->attach($supplierPermissions);
        }
        if ($request->has('reports_permissions')) {
            $reportsPermissions = Permission::whereIn('name', $request->input('reports_permissions'))->get();
            $role->permissions()->attach($reportsPermissions);
        }

        if ($request->has('userManagement_permissions')) {
            $userPermissions = Permission::whereIn('name', $request->input('userManagement_permissions'))->get();
            $role->permissions()->attach($userPermissions);
        }
        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('name', $request->input('permissions'))->get();
            $role->permissions()->attach($permissions);
        }

        if ($request->has('modelChange_permissions')) {
            $modelPermissions = Permission::whereIn('name', $request->input('modelChange_permissions'))->get();
            $role->permissions()->attach($modelPermissions);
        }
        if ($request->has('application_permissions')) {
            $applicationPermissions = Permission::whereIn('name', $request->input('application_permissions'))->get();
            $role->permissions()->attach($applicationPermissions);
        }

        if ($request->has('customerPermissions')) {
            $customerPermissions = Permission::whereIn('name', $request->input('customerPermissions'))->get();
            $role->permissions()->attach($customerPermissions);
        }

      

        return response()->json(['message' => 'Role and Primission stored successfully']);
    }
}
