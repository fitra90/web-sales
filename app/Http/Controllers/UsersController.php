<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function home(Request $request)
    {
        if ($request->session()->has('login')) {
            return redirect('/stuffs');
        } else {
            return redirect('/login');
        }
    }

    public function getAll()
    {
        return User::all();
    }

    public function viewAll(Request $request)
    {
        if ($request->session()->has('login') &&  session('role') == 1) {
            $data = $this->getAll();
            return view('users', ['data' => $data]);
        } else {
            return redirect('/stuffs');
        }
    }

    public function viewNew(Request $request)
    {
        if ($request->session()->has('login') &&  session('role') == 1) {
            return view('form-user');
        } else {
            return redirect('/stuffs');
        }
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

    public function viewEdit(Request $request, $id)
    {
        if ($request->session()->has('login') && session('role') == 1) {
            $data  = User::where('id', $id)->first();
            return view('form-user', ['data' => $data]);
        } else {
            return redirect('/stuffs');
        }
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

    public function login(Request $request) {
        if ($request->session()->has('login')) {
            return redirect('/stuffs');
        } else {
            return view('login');
        }
    }

    public function getLogin(Request $post)
    {
        $data = $post->input();
        $user = User::where([['username', '=', $data['username']], ['password', '=', sha1($post['password'])]])->first();
        if ($user && $user->status > 0 && $user->role == 2 && $user->status > 0) {

            session(['username' => $user->username, 'role' => '2', 'name' => $user->name, 'login' => true]);
            return redirect()->action([StuffsController::class, 'viewAll']);
        } else if ($user && $user->status > 0 && $user->role == 1 && $user->status > 0) {
            session(['username' => $user->username, 'role' => '1', 'name' => $user->name, 'login' => true]);
            return redirect()->action([StuffsController::class, 'viewAll']);
        } else {
            session()->flash('error', '');
            return redirect('/login');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect("/login");
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
