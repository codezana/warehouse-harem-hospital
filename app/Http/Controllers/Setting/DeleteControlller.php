<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeleteControlller extends Controller
{
    public function deletePremission(Request $request)
    {
    
            $id=$request->input('id');
            $role = Role::findOrFail($id);

      
            if ($role->users()->count() > 0) {
                $users = $role->users()->get();
            
                // Disable the users
                foreach ($users as $user) {
                    try {
                        $user->update(['is_enabled' => false]);
                    } catch (\Exception $e) {
                        Log::error($e->getMessage());
                        return response()->json(['error' => 'Unable to update is_enabled.'], 400);
                    }
                }
            
            }
            

            // Detach all permissions associated with this role
            $role->permissions()->detach();

            // Delete the role
            $role->delete();

            return response()->json(['success' => 'Role and associated permissions deleted successfully.']);

    }



    

}
