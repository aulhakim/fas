<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use DB;
use File;
use Image;
use Hash;
use Session;
class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
      $user = Auth::user()->id;
    
        // if(!$user){
        //     return redirect()->route('login');
        // }else{
                
            return view('admin/dashboard');
        // }
    }
    public function dashboard()
    {
        return view('admin/dashboard');
    }
    public function category()
    {
        return view('admin/category');
    }
    public function getCategory(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('category')->orderBy('created_at','desc')->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                   
                    ->addColumn('statusCategory', function($status){
                        if($status->status == "1"){
                            $statusnya = "Active";
                        }else{
                            $statusnya = "Non Active";
                        }
                         return $statusnya;
                    })
                    ->rawColumns(['statusCategory'])
                    ->addColumn('action', function($row){
                            $btn = '<a href="javascript:void(0)" onClick="editData(\''.$row->id.'\')" class="edit btn-secondary  btn-sm">Edit</a>
                            <a href="javascript:void(0)"  onClick="deleteCategory(\''.$row->id.'\')"  class="edit btn-secondary btn-sm">Delete</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    
                    ->make(true);
        }
    }
    public function getCategoryById($id)
    {
        $kategori = DB::table('category')
                        ->where('id', '=', $id)
                        ->get();
            $a = $kategori->first();
            return json_encode($a);

    }
    public function store(Request $val)
    { 
        DB::table('category')->insert(
            array(
                    'name' => $val->name, 
                    'slug' => $this->slugify($val->name), 
                    'status' => $val->status,
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' =>  Auth::user()->id
            )
        );
    }
    public function updateCategory(Request  $request)
    {
        DB::table('category')
        ->where('id', $request->id)
        ->update([
            'title' => $request->title,
            'slug' => $this->slugify($request->title),
            'status' => $request->status,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' =>  Auth::user()->id
            ]);
    }
    public function deleteCategory($id){
        DB::table('category')->where('id',$id)->delete();
    }


    // blog
    public function blog()
    {
        $data['category'] = DB::table('category')->where('status','1')->get();
        return view('admin/blog',$data);
    }

    public function getBlog(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('blog')
            ->orderBy('created_at','desc')
            ->leftJoin('users', 'blog.created_by', '=', 'users.id')
            ->select('blog.*', 'users.name')
            ->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('status', function($status){
                        if($status->status == "1"){
                            $statusnya = "Active";
                        }else{
                            $statusnya = "Non Active";
                        }
                         return $statusnya;
                    })
                    ->rawColumns(['status'])
                    ->addColumn('action', function($row){
                            $btn = '<a href="'.url('admin/blog/edit/'.$row->id).'" class="edit btn-secondary  btn-sm">Edit</a>
                            <a href="javascript:void(0)"  onClick="deleteBlog(\''.$row->id.'\')"  class="edit btn-secondary btn-sm">Delete</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }
    public function addBlog()
    {
        $kategory = DB::table('category')->where('status','1')->get();
        $data = array(
            "label"=>"Add Blog",
            "title"=>"",
            "content"=>"",
            "category"=>$kategory,
            "category_id"=>"",
            "blog_id"=>"",
            "short_description"=>"",
            "status"=>"1",
            "image2"=>"",
            "action"=>"/admin/blog/insert" 
        );

        return view('admin.addBlog',$data);
    }
    public function storeBlog(Request $request)
    { 
        $file = $request->file('image');
        $names = $file->getClientOriginalName();
        $tes = number_format(round(microtime(true) * 1000),0,"","");
        $file_name = "blog"."-".$tes.$names;
        $request->validate([ 
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,PNG,JPG,JPEG|max:2048',
        ]);

        $destinationPath = public_path('/assets/image/blog_thumb');
        $img = Image::make($file->path());
        $img->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$file_name);

        $request->image->move(public_path('assets/image/blog/'),$file_name);
        DB::table('blog')->insert(
                array(
                'title' => $request->title,
                'category_id' => $request->category_id,
                'created_by' =>  Auth::user()->id,
                'short_description' => $request->short_description,
                'content' => $request->content,
                'image' => $file_name,
                'created_at' => date('Y-m-d H:i:s'),
                'status' => $request->status,
                'slug' => $this->slugify($request->title),


            ));
            return redirect('admin/blog');
        }

        public function editBlog($id)
        {
            $kategory = DB::table('category')->where('status','1')->get();
            $blog = DB::table('blog')
                         ->where('id', '=', $id)
                         ->get();
            $a = $blog->first();
            $data = array(
                "label"=>"Update Blog",
                "title"=>$a->title,
                "short_description"=>$a->short_description,
                "content"=>$a->content,
                "category"=>$kategory,
                "category_id"=>$a->category_id,
                "blog_id"=>$a->id,
                  "status"=>$a->status,

                "image2"=>$a->image,
                "action"=>"/admin/blog/update" 
            );
            return view('admin.addBlog',$data);
        }
    
        public function updateBlog(request $request)
        {
    
            $file = $request->file('image');
            if($file != null){
                $names = $file->getClientOriginalName();
                $tes = number_format(round(microtime(true) * 1000),0,"","");
                $file_name = "blog"."-".$tes.$names;
                $request->validate([ 
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,PNG,JPG,JPEG|max:2048',
                ]);
                $destinationPath = public_path('/assets/image/blog_thumb');
                $img = Image::make($file->path());
                $img->resize(100, 100, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$file_name);
                
                $request->image->move(public_path('assets/image/blog/'),$file_name);
            }else{
                $file_name = $request->image2;
            }
            
    
            DB::table('blog')->where('id', $request->id)
            ->update([
                'title' => $request->title,
                'category_id' => $request->category_id,
                'short_description' => $request->short_description,
                'content' => $request->content,
                'image' => $file_name,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' =>  Auth::user()->id,
                'status' => $request->status,
                'slug' => $this->slugify($request->title),

                ]);
            return redirect('admin/blog');
        }
    
        public function deleteBlog($id){
            $blog = DB::table('blog')->where('id', '=', $id)->get();
            $a = $blog->first();
            $image_path = "assets/image/blog/".$a->image; 
            $image_thumb = "assets/image/blog_thumb/".$a->image; 
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            if(File::exists($image_thumb)) {
                File::delete($image_thumb);
            }

            DB::table('blog')->where('id',$id)->delete();
        }

        public function changePassword()
        {
            return view('admin.changePassword');
        }
        public function doChangePassword(request $request)
        {
            $id = $request->id;
            $new_pass = Hash::make($request->new_pass);
      

            if(!\Hash::check($request->old_pass, auth()->user()->password)){
                return back()->with('error','You have entered wrong old password');
           }elseif($request->new_pass != $request->conf_pass){
                return back()->with('error','Password does not match');
           }else{

            DB::table('users')->where('id', $request->id)
            ->update([
                'password' => $new_pass
                ]);
             return back()->with('success','Password success changed');


           }


        }

    public static function slugify($text) {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }
}
