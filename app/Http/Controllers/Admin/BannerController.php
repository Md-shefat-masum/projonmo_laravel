<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collection = Banner::where('status',1)->latest()->paginate(10);
        return view('admin.banner.index',compact('collection'));
    }

    public function get_banner_json()
    {
        $collection = Banner::where('status',1)->latest()->get();
        $options = '';
        foreach ($collection as $key => $value) {
            $options .= "<option ".($key==0?' selected':'')." value='".$value->id."'>".$value->name."</option>";
        }
        return $options;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banner.create');
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
            // 'name' => ['required'],
            'icon' => ['required'],
        ]);
        $banner = Banner::create($request->except('icon'));

        if($request->hasFile('icon')){
            $banner->icon = Storage::put('uploads/banner',$request->file('icon'));
            $banner->save();
        }

        $banner->slug = Str::slug($banner->name).rand(1999,9999).$banner->id;
        $banner->creator = Auth::user()->id;
        $banner->save();

        return response()->json([
            'html' => "<option value='".$banner->id."'>".$banner->name."</option>",
            'value' => $banner->id,
        ]);
        // return redirect()->back()->with('success','data created successfully');
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
    public function edit(Banner $banner)
    {
        return view('admin.banner.edit',compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        $this->validate($request,[
            'icon' => ['required']
        ]);

        $banner->update($request->except('icon'));

        if($request->hasFile('icon')){
            $banner->icon = Storage::put('uploads/banner',$request->file('icon'));
            $banner->save();
        }

        $banner->slug = Str::slug($banner->name).rand(1999,9999).$banner->id;;
        $banner->creator = Auth::user()->id;
        $banner->save();

        return 'success';
        // return redirect()->back()->with('success','data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
        return 'success';
    }
}
