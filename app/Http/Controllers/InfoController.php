<?php

namespace App\Http\Controllers;

use App\Http\Requests\InfoRequest;
use App\Models\Info;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function index()
    {
        $infos = Info::get();
        return view('index', compact('infos'));
    }
    public function create($storage)
    {
        return view('create', compact('storage'));
    }
    public function store(InfoRequest $request)
    {
        $fileName = time() . '.' . $request->file->extension();

        $route = ($request->storage == "public") ? 'public/images' : 'private/images';

        $request->file->storeAs($route, $fileName);

        $info = new Info;
        $info->name = $request->name;
        $info->file_uri = $fileName;
        $info->save();
        return redirect()->route('index');
    }
}
