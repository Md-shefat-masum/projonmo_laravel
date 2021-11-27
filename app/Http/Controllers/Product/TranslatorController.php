<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Translator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TranslatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collection = Translator::where('status',1)->latest()->paginate(10);
        return view('admin.product.translator.index',compact('collection'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product.translator.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => ['required'],
            // 'description' => ['required'],
            // 'image' => ['required'],
        ]);

        $translator = Translator::create($request->except('image'));

        if($request->hasFile('image')){
            $translator->image = Storage::put('uploads/writer',$request->file('image'));
            $translator->save();
        }

        $translator->slug = Str::slug($translator->name);
        $translator->creator = Auth::user()->id;
        $translator->save();

        return response()->json([
            'html' => "<option value='".$translator->id."'>".$translator->name."</option>",
            'value' => $translator->id,
        ]);
        // return 'success';
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
    public function edit(Translator $translator)
    {
        return view('admin.product.translator.edit',compact('translator'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Translator $translator)
    {
        $this->validate($request,[
            'name' => ['required'],
            // 'description' => ['required']
        ]);

        $translator->update($request->except('image'));

        if($request->hasFile('image')){
            $translator->logo = Storage::put('uploads/writer',$request->file('image'));
            $translator->save();
        }

        $translator->slug = Str::slug($translator->name);
        $translator->creator = Auth::user()->id;
        $translator->save();

        return 'success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Translator $translator)
    {
        $translator->delete();
        return 'success';
    }
}
