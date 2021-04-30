<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\User;

class Home extends Controller
{
   public function index()
   {
      $category = DB::table('category')->where('status','1')->get();
      $data = DB::table('blog')
            ->leftJoin('users', 'blog.created_by', '=', 'users.id')
            ->leftJoin('category', 'blog.category_id', '=', 'category.id')
            ->orderBy('created_at','desc')
            ->where('blog.status','1')
            ->select('blog.*', 'users.name','category.name as category')
            ->paginate(10);
      return view('home',compact('data','category'));
   }
   public function blogDetail($slug)
   {
      $category = DB::table('category')->where('status','1')->get();
      $data = DB::table('blog')
            ->leftJoin('users', 'blog.created_by', '=', 'users.id')
            ->leftJoin('category', 'blog.category_id', '=', 'category.id')
            ->orderBy('created_at','desc')
            ->where('blog.status','1')
            ->where('blog.slug',$slug)
            ->select('blog.*', 'users.name as creater','category.name as category')
            ->first();
      $newest = DB::table('blog')
            ->leftJoin('users', 'blog.created_by', '=', 'users.id')
            ->leftJoin('category', 'blog.category_id', '=', 'category.id')
            ->orderBy('created_at','desc')
            ->where('blog.status','1')
            ->select('blog.*', 'users.name','category.name as category')
            ->limit('5')
            ->get();
      return view('blogDetail',compact('data','category','newest'));

   }
   public function blogByCategory($slug)
   {
      $category = DB::table('category')->where('status','1')->get();
      $cat = DB::table('category')->where('slug',$slug)->first();
      $data = DB::table('blog')
            ->leftJoin('users', 'blog.created_by', '=', 'users.id')
            ->leftJoin('category', 'blog.category_id', '=', 'category.id')
            ->orderBy('created_at','desc')
            ->where('blog.status','1')
            ->where('blog.category_id',$cat->id)
            ->select('blog.*', 'users.name as creater','category.name as category')
            ->paginate(10);
     
      return view('blogByCategory',compact('data','category'));
   }

}
