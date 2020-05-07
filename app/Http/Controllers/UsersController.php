<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\EditUser;
use App\Http\Requests\StoreUser;
//use Prologue\Alerts\Facades\Alert;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;

class UsersController extends Controller
{
    /**
     * The attributes that are mass assignable.
     *
     * @var object $array
     */
    private $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->getAll();
        return view('admin/users/index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        $action = 'create';
        $formData = array('route' => 'admin.users.store', 'method' => 'POST');
        
        return view('admin/users/form', compact('action', 'user', 'formData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUser  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
        $data = $request->validated();

        $user = new User();
        $user->create($data);
        // send mail
        //$token = Password::getRepository()->create($user);
        //$user->sendPasswordResetNotification($token);

        return redirect()->route('admin.users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = new User();
        $myUser = $user->getEdit($id);

        $action    = 'update';
        $formData = array('route' => array('admin.users.update', $myUser->id), 'method' => 'PATCH');

        return view('admin/users/form', compact('action', 'myUser', 'formData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\EditUser  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @SuppressWarnings(PHPMD)
     */
    public function update(EditUser $request, $id)
    {
        $user = User::getEdit($id);

        $data = $request->validated();

        $user->fill($data)->save();

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @SuppressWarnings(PHPMD)
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        try {
            $user->delete();
            //Alert::success('Registro eliminado correctamente!')->flash();
        } catch (Exception $e) {
            //Alert::error('No puedes eliminar el registro!')->flash();
        }

        return redirect()->route('admin.users.index');
    }
}
