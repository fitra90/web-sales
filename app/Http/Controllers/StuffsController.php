<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stuff;

class StuffsController extends Controller
{
    
    public function getAll() {
        return Stuff::all();
    }

    public function viewAll() {
        $data = $this->getAll();
        return view('stuffs', ['data' => $data]);
    }

    public function viewNew() {
        return view('form-stuff');
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
    
    public function viewEdit($id) {
        $data  = Stuff::where('id',$id)->first();
        return view('form-stuff', ['data' => $data]);
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
