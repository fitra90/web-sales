<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{

    public function getAll()
    {
        return User::all();
    }

    public function viewAll()
    {
        $data = $this->getAll();
        return view('users', ['data' => $data]);
    }

    public function viewNew()
    {
        return view('form-user');
    }

    public function saveNew(Request $post)
    {
        $user = new User;
        $data = $post->input();
        $user->name = $data['name'];
        $user->username = $data['username'];
        $user->status = $data['status'];
        $user->password = sha1($data['password']);
        $user->role = $data['role'];
        $save = $user->save();
        if ($save) {
            return redirect('/users');
        } else {
            return redirect('/new-user');
        }
    }

    public function saveEdit(Request $post, $id)
    {
        $data = $post->input();
        $update = User::where('id', "=", $id)->update(array(
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => $data['password'],
            'role' => $data['role'],
            'status' => $data['status']
        ));
        if ($update) {
            return redirect('/users');
        } else {
            return redirect('/edit-user/' . $id);
        }
    }

    public function viewEdit($id)
    {
        $data  = User::where('id', $id)->first();
        return view('form-user', ['data' => $data]);
    }

    public function delete($id)
    {
        $data  = User::where('id', $id)->first();
        if ($data != null) {
            $data->delete();
            return true;
        } else {
            return false;
        }
    }

    public function index()
    {
        return Response($this->getAll());
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
}
