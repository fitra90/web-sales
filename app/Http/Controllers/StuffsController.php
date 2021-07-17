<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stuff;

class StuffsController extends Controller
{
    
    public function getAll() {
        return Stuff::all();
    }

    public function viewAll(Request $request) {
        if ($request->session()->has('login')) {
            $data = $this->getAll();
            return view('stuffs', ['data' => $data, 'session'=>$request->session()->all()]);
        } else {
            return redirect('/login');
        }
    }

    public function viewNew(Request $request) {
        if ($request->session()->has('login') && session('role') == 1) {
            return view('form-stuff');
            // return redirect('/login');
        } else {
            return redirect('/stuffs');
        }
    }
    
    public function saveNew(Request $post) {
        $stuff = new Stuff;
        $data = $post->input();
        $stuff->name = $data['name'];
        $stuff->stock = $data['stock'];
        $stuff->status = $data['status'];
        $save = $stuff->save();
        if($save) {
            return redirect('/stuffs');
        } else{
            return redirect('/new-stuff');
        }
    }
    
    public function saveEdit(Request $post, $id) {
        $data = $post->input();
        $update = Stuff::where('id', "=", $id)->update(array(
            'name' => $data['name'],
            'stock' => $data['stock'],
            'status' => $data['status']
        ));
        if($update) {
            return redirect('/stuffs');
        } else{
            return redirect('/edit-stuff/'.$id);
        }
    }
    
    public function viewEdit(Request $request, $id) {
        if ($request->session()->has('login') &&  session('role') == 1) {
            $data  = Stuff::where('id',$id)->first();
            return view('form-stuff', ['data' => $data]);
        } else {
            return redirect('/stuffs');
        }
    }
    
    public function delete($id) {
        $data  = Stuff::where('id',$id)->first();
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
