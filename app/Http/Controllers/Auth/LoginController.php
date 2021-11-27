<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image as interImage;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function attemptLogin(Request $request)
    {

        $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
        // dd($request->all());
        if(!User::where('email',$request->email)->exists()){
            Auth::logout();
            return redirect()->back()->with('error','your accont is blocked');;
        }
        if(Auth::check() && Auth::user()->status == 0){
            Auth::logout();
            return redirect()->back()->with('error','your accont is blocked');;
        }
        return '/admin';
    }

    public function custom_logout()
    {
        if(Auth::check()){
            Auth::logout();
        }
        return redirect('/');
    }

    public function custome_login(Request $request)
    {
        $this->validate($request,[
            'email' => 'required',
            'password' => 'required',
        ]);

        $check_by_email = User::where('email',$request->email)->exists();
        $check_by_username = User::where('username',$request->email)->exists();
        $check_by_phone = User::where('phone',$request->email)->exists();

        if($check_by_email){
            $user = User::where('email',$request->email)->first();
            if(Hash::check($request->password,$user->password)){
                Auth::login($user);
                return response()->json([
                    'auth_info' => $user,
                    'auth_status' => true,
                ]);
            }else{
                return response()->json([
                    'auth_info' => null,
                    'auth_status' => false,
                    'errors' => [
                        'email' => ['email or password is incorrect'],
                        'password' => ['email or password is incorrect'],
                    ]
                ]);
            }
        }else if($check_by_username){
            $user = User::where('username',$request->email)->first();
        }else if($check_by_phone){
            $user = User::where('phone',$request->email)->first();
        }else{
            return response()->json([
                'auth_info' => null,
                'auth_status' => false,
                'errors' => [
                    'email' => ['email or password is incorrect'],
                    'password' => ['email or password is incorrect'],
                ]
            ]);
        }
    }

    public function custom_register(Request $request)
    {
        if(Auth::check()){
            Auth::logout();
        }
        $this->validate($request,[
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'photo' => ['mimes:jpg,png','file','max:1000','dimensions:min_width=200,min_height=200'],
        ],[
            'photo.max' => "Maximum file size to upload is 1MB (1000 KB). If you are uploading a photo, try to reduce its resolution to make it under 1MB",
            'photo.dimensions' => "photo should be passport size 200x200"
        ]);

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->created_at = Carbon::now()->toDateTimeString();
        $user->save();
        $user->slug = $user->name.'-'.$user->id.rand(1000,9999);
        $user->save();

        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $temp_name  = uniqid(10) . $user->id;
            $path = 'uploads/user/user' . $temp_name . '.' . $extension;
            $image = interImage::make($file);
            $image->fit(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image->save($path);
            $user->photo = $path;
            $user->save();
        }

        Auth::login($user);
        return response()->json([
            'auth_info' => $user,
            'auth_status' => true,
        ]);
    }


}
