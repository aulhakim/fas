<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use Session;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use DB;
class AuthController extends Controller
{
    public function showFormLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin');
        }else{
            return view('login');
        }
           
      
    }
  
    public function login(Request $request)
    {

        $rules = [
            'email'                 => 'required|email',
            'password'              => 'required|string'
        ];
        $messages = [
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid',
            'password.required'     => 'Password wajib diisi',
            'password.string'       => 'Password harus berupa string'
        ];
  
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
  
        $data = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password'),
        ];
        Auth::attempt($data);
  
        if (Auth::check()) { 
            
            return redirect()->route('admin');
  
        } else { 
  
           
            Session::flash('error', 'Email atau password salah');
            return redirect()->route('login');
        }
  
    }
  
    public function showFormRegister()
    {
        return view('register');
    }
  
    public function register(Request $request)
    {
        $rules = [
            'name'                  => 'required|min:3|max:35',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|confirmed'
        ];
  
        $messages = [
            'name.required'         => 'Nama Lengkap wajib diisi',
            'name.min'              => 'Nama lengkap minimal 3 karakter',
            'name.max'              => 'Nama lengkap maksimal 35 karakter',
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid',
            'email.unique'          => 'Email sudah terdaftar',
            'password.required'     => 'Password wajib diisi',
            'password.confirmed'    => 'Password tidak sama dengan konfirmasi password'
        ];
  
        $validator = Validator::make($request->all(), $rules, $messages);
  
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
  
        $user = new User;
        $user->name = ucwords(strtolower($request->name));
        $user->email = strtolower($request->email);
        $user->password = Hash::make($request->password);
        $user->email_verified_at = \Carbon\Carbon::now();
        $simpan = $user->save();
  
        if($simpan){
            Session::flash('success', 'Register berhasil! Silahkan login untuk mengakses data');
            return redirect()->route('login');
        } else {
            Session::flash('errors', ['' => 'Register gagal! Silahkan ulangi beberapa saat lagi']);
            return redirect()->route('register');
        }
    }
  
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }


    // google signup
    public function redirectToGoogle()
    {
       return Socialite::driver('google')->redirect();
       
    }
    public function handleGoogleCallback()
    { 
        try {
            $user = Socialite::driver('google')->stateless()->user();
            $isUser = User::where('provider_id', $user->id)->first();
            if($isUser){
                Auth::login($isUser);
                return redirect('/admin');
 
            } else { 

                $email = DB::table('users')->where('email', '=', $user->getEmail())->first();

                if($email == null){
                    $createUser = new User;
                    $createUser->name =  $user->getName();
                    $createUser->provider =  "google";
                    if($user->getEmail() != null){
                        $createUser->email = $user->getEmail();
                        $createUser->email_verified_at = \Carbon\Carbon::now();
                    }  
                    $createUser->provider_id = $user->getId();
                    $rand = rand(111111,999999);
                    $createUser->password = Hash::make($user->getName().$rand);
                    $createUser->save();
                    Auth::login($createUser);
                    return redirect('/admin');
                }else{
                    Session::flash('error', 'Email sudah terdaftar');
                    return redirect('/register');
                }
               
            }
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
    // facebook 
    public function redirectToFacebook()
    {
       return Socialite::driver('facebook')->redirect();
    }
    public function handleFacebookCallback()
    {

        try {
     
            $user = Socialite::driver('facebook')->stateless()->user();
 
            $isUser = User::where('provider_id', $user->id)->first();
             
            if($isUser){
                 
                Auth::login($isUser);
                return redirect('/admin');
 
            } else { 
                $email = DB::table('users')->where('email', '=', $user->getEmail())->first();

                if($email == null){
                        $createUser = new User;
                        $createUser->name =  $user->getName();
                        $createUser->provider =  "facebook";

                        if($user->getEmail() != null){
                            $createUser->email = $user->getEmail();
                            $createUser->email_verified_at = \Carbon\Carbon::now();
                        }  
                        
                        $createUser->provider_id = $user->getId();
        
                        $rand = rand(111111,999999);
                        $createUser->password = Hash::make($user->getName().$rand);
        
                        $createUser->save();
                        
                        Auth::login($createUser);
                        return redirect('/admin');
                }else{
                    Session::flash('error', 'Email sudah terdaftar');

                    return redirect('/register');
                }
            }
     
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }


    }
    // gitihub signup
    public function redirectToGithub()
    {
       return Socialite::driver('github')->redirect();
    }
    public function handleGithubCallback()
    {
        try {
        
            $user = Socialite::driver('github')->stateless()->user();

            $isUser = User::where('provider_id', $user->id)->first();
            
            if($isUser){
                
                Auth::login($isUser);
                return redirect('/admin');

            } else { 

                $email = DB::table('users')->where('email', '=', $user->getEmail())->first();
                if($email == null){
                    $createUser = new User;
                    $createUser->name =  $user->getName();
                    $createUser->provider =  "github";
                    if($user->getEmail() != null){
                        $createUser->email = $user->getEmail();
                        $createUser->email_verified_at = \Carbon\Carbon::now();
                    }  
                    $createUser->provider_id = $user->getId();
                    $rand = rand(111111,999999);
                    $createUser->password = Hash::make($user->getName().$rand);
                    $createUser->save();
                    Auth::login($createUser);
                    return redirect('/admin');
                }else{
                    Session::flash('error', 'Email sudah terdaftar');

                    return redirect('/register');
                }
            }
    
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
        
    }

  

}
