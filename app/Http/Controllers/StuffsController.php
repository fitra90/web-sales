<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stuff;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StuffsController extends Controller
{

    public function getAll()
    {
        return DB::table('stuffs')->paginate(5);
    }

    public function viewAll(Request $request)
    {
        if ($request->session()->has('login')) {
            $data = $this->getAll();
            return view('stuffs', ['data' => $data, 'session' => $request->session()->all()]);
        } else {
            return redirect('/login');
        }
    }

    public function viewNew(Request $request)
    {
        if ($request->session()->has('login') && session('role') == 1) {
            return view('form-stuff');
            // return redirect('/login');
        } else {
            return redirect('/stuffs');
        }
    }

    public function saveNew(Request $post)
    {
        $stuff = new Stuff;
        $data = $post->input();
        $file = $post->file('picture');
        //check if file upload exist
        if (isset($file)) {
            $storeName = md5($file->getClientOriginalName()) . "." . $file->extension();
            Storage::putFileAs(
                'public/pictures',
                $file,
                $storeName,
                'public'
            );
        }

        $stuff->name = $data['name'];
        $stuff->stock = $data['stock'];
        $stuff->status = $data['status'];
        $stuff->picture = $storeName;
        $stuff->price = $data['price'];
        $stuff->type = $data['type'];

        $save = $stuff->save();
        if ($save) {
            return redirect('/stuffs');
        } else {
            return redirect('/new-stuff');
        }
    }

    public function saveEdit(Request $post, $id)
    {
        $data = $post->input();
        $file = $post->file('picture');
        $old = Stuff::where('id', $id)->first();
        $oldPicture = $old->picture;

        if (isset($file)) {
            $storeName = md5($file->getClientOriginalName()) . "." . $file->extension();
            Storage::putFileAs(
                'public/pictures',
                $file,
                $storeName,
                'public'
            );
            Storage::delete('public/pictures/' . $oldPicture);
        } else {
            $storeName = $oldPicture;
        }

        $update = Stuff::where('id', "=", $id)->update(array(
            'name' => $data['name'],
            'stock' => $data['stock'],
            'status' => $data['status'],
            'price' => $data['price'],
            'picture' => $storeName,
            'type' => $data['type']
        ));
        if ($update) {
            return redirect('/stuffs');
        } else {
            return redirect('/edit-stuff/' . $id);
        }
    }

    public function viewEdit(Request $request, $id)
    {
        if ($request->session()->has('login') &&  session('role') == 1) {
            $data  = Stuff::where('id', $id)->first();
            return view('form-stuff', ['data' => $data]);
        } else {
            return redirect('/stuffs');
        }
    }

    public function delete($id)
    {
        $data  = Stuff::where('id', $id)->first();
        Storage::delete('public/pictures/' . $data->picture);
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
