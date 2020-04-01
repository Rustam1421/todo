<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function storeUser($id)
    {
        $user = User::find($id);
        $roleId = Role::find($id);
        $user->save();
        $user->syncRoles($roleId);
        return redirect('/home/admin');
    }
}
