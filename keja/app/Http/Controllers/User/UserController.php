<?php

namespace App\Http\Controllers\User;

use App\User;
use foo\bar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Innox\Classes\Repository\PaymentRepository;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (! auth()->user()->can('browse_user'))
        {
            flash('Access Denied')->warning()->important();
            return  back();
        }

        $users = User::active()->get();

        return  view('users.user.index')->with([
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! auth()->user()->can('add_user'))
        {
            flash('Access Denied')->warning()->important();
            return  back();
        }

        return view('users.user.create')
            ->with([
                'roles' => Role::all()
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
        if (! auth()->user()->can('add_user'))
        {
            flash('Access Denied')->warning()->important();
            return  back();
        }

        $this->validate($request , [
            'name'  => 'required',
            'email' => [
                'email',
                'max:255',
                Rule::unique('users','email')
            ],
            'phone_number' => [
                'required',
                'max:255',
                Rule::unique('users','phone_number')
            ],
            'password'  => ['required', 'string', 'min:6', 'confirmed'],
        ]);


        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone_number'  => $request['phone_number'],
            'password' => Hash::make($request['password']),
        ]);
        $role = Role::find($request['role_id']);

        $user->assignRole($role->name);

        flash('successfully created user')->success()->important();
        return  redirect()
            ->route('user_browse')
            ->send();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! auth()->user()->can('edit_user'))
        {
            flash('Access Denied')->warning()->important();
            return  back();
        }
        $user = User::find($id);
        \request()->request->add(['user_id' => $id]);

        $payments = (new PaymentRepository())->filter();

        return  view('users.user.edit')
            ->with([
                'user' => $user,
                'roles' => Role::all(),
                'payments'  => $payments
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (! auth()->user()->can('edit_user'))
        {
            flash('Access Denied')->warning()->important();
            return  back();
        }


        $this->validate($request , [
            'name'  => 'required',
            'email' => [
                'email',
                'max:255',
                Rule::unique('users','email')->ignore($id)
            ],
            'phone_number' => [
                'required',
                'max:255',
                Rule::unique('users','phone_number')->ignore($id)
            ],
            'password'  => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::find($id);

        $user->email =  $request['email'];
        $user->name =  $request['name'];
        $user->phone_number =  $request['phone_number'];

        if (isset($request['password']) && ! is_null($request['password']))
        {
            $user->password =  Hash::make($request['password']);
        }

        $user->save();

        if ( isset($request['role_id']))
        {
            foreach ($user->getRoleNames() as $roleName) {
                $role = Role::findByName($roleName);
                $user->removeRole($role);
            }

            $role = Role::find($request['role_id']);
            $user->assignRole($role->name);
        }

        flash('successfully updated user')->success()->important();
        return  redirect()
            ->route('user_browse')
            ->send();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! auth()->user()->can('deactivate_user'))
        {
            flash('Access Denied')->warning()->important();
            return  back();
        }
        $user = User::find($id);
        $user->is_active = false;
        $user->save();
        flash('successfully deactivated user')->success()->important();
        return  redirect()
            ->route('user_browse')
            ->send();
    }
}
