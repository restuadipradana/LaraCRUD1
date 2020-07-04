<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PertanyaanModel;
use Redirect;

class PertanyaanController extends Controller
{
    //
    public function index() {
        $items = PertanyaanModel::get_all();
        //dd($items);
        return view('larahub.pertanyaan.index', compact('items'));
    }

    public function create() {
        return view('larahub.pertanyaan.form');
    }

    public function store(Request $request) {
        //dd($request->all());
        
        $data = $request->all();
        unset($data["_token"]);
        $dt = array("tanggal_dibuat" => Carbon::now('Asia/Jakarta')->toDateTimeString());
        $data = array_merge($data, $dt);
        //dd($data);
        $item = PertanyaanModel::save($data);
        if($item){
            return Redirect::to('/pertanyaan');
        }
        else{
            return view('larahub.exception');
        }
        //return view('larahub.pertanyaan.form');
    }

    public function edit($id) {
        $pertanyaan = PertanyaanModel::findById($id);
        //dd($pertanyaan);
        return view('larahub.pertanyaan.formEdit', compact('pertanyaan'));
    }

    public function update(Request $request, $id) {
        $data = $request->all();
        $dt = array("tanggal_diperbarui" => Carbon::now('Asia/Jakarta')->toDateTimeString());
        $data = array_merge($data, $dt);
        $item = PertanyaanModel::update($data, $id);
        $link = "/jawaban/" . $id;
        return Redirect::to($link);
    }

    public function delete($id) {
        $delete = PertanyaanModel::delete($id);
        return redirect('/pertanyaan');
    }

}
