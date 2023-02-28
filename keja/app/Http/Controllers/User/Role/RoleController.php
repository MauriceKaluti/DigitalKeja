<?php

namespace App\Http\Controllers\User\Role;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! auth()->user()->can('browse_role'))
        {
            flash('Access denied' )->warning()->important();
            return  redirect('/');
        }

        return  view('users.role.index')
            ->with([
                'roles' => Role::all(),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! auth()->user()->can('add_role'))
        {
            flash('Access denied' )->warning()->important();
            return  redirect('/');
        }
        return  view('users.role.create')
            ->with([
                'permissions'  => Permission::all()
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('add_role'))
        {
            flash('Access denied' )->warning()->important();
            return  redirect('/');
        }

        $role = Role::create(['name' => $request['name']]);
        // ASSIGN PERM TO ROLES

        if (isset($request['permission_id']) && ! is_null($request['permission_id']))
        {
            foreach ($request['permission_id'] as $key => $perm) {
                $permission = Permission::findById($perm);

                $role->givePermissionTo($permission);

            }
        }
        flash('Successfully created a role '. $role->name )->success()->important();
        return  redirect()->route('user_role');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! auth()->user()->can('read_role'))
        {
            flash('Access denied' )->warning()->important();
            return  redirect('/');
        }
        return  view('users.role.edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        if (! auth()->user()->can('edit_role'))
        {
            flash('Access denied' )->warning()->important();
            return  redirect('/');
        }

        return  view('users.role.edit')
            ->with([
                'permissions'  => Permission::all(),
                'role'  => Role::find($id)
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {

        if (! auth()->user()->can('edit_role'))
        {
            flash('Access denied' )->warning()->important();
            return  redirect('/');
        }


        $this->validate($request ,[
            'name' => [
                'required',
                Rule::unique('roles')->ignore($role->id)
            ]
        ]);


        $role->update(['name' => $request['name']]);
        // ASSIGN PERM TO ROLES
        $role->syncPermissions();

         // ASSIGN PERM TO ROLES

        if (isset($request['permission_id']) && ! is_null($request['permission_id']))
        {
            foreach ($request['permission_id'] as $key => $perm) {
                $permission = Permission::findById($perm);

                $role->givePermissionTo($permission);

            }
        }
        flash('Successfully created a role '. $role->name )->success()->important();
        return  redirect()->route('user_role');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
