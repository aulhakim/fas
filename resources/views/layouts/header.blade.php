<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <title>FAS BLOG</title>
  </head>
  <body>
    
    <div class="container">
      <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
          <div class="col-4 pt-1">
            <a class="text-muted" href="{{url('/')}}">Home</a>
          </div>
          <div class="col-4 text-center">
            <a class="blog-header-logo text-dark" href="#">FAS BLOG</a>
          </div>
          <div class="col-4 d-flex justify-content-end align-items-center">
            <a class="text-muted" href="#" aria-label="Search">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="mx-3" role="img" viewBox="0 0 24 24" focusable="false"><title>Search</title><circle cx="10.5" cy="10.5" r="7.5"/><path d="M21 21l-5.2-5.2"/></svg>
            </a>
                @if (Auth::check())
                <a class="btn btn-sm btn-outline-secondary" href="{{url('admin')}}">Dashboard</a>
                @else
               
                <a class="btn btn-sm btn-outline-secondary mr-2" href="{{url('login')}}">Login</a>
                <a class="btn btn-sm btn-outline-secondary" href="{{url('register')}}">Sign up</a>
                @endif
           
          </div>
        </div>
      </header>
    
      <div class="nav-scroller py-1 mb-2">
        <nav class="nav d-flex justify-content-between">
          @foreach ($category as $cat)
          <a class="p-2 text-muted" href="{{url('category/'.$cat->slug.'')}}">{{$cat->name}}</a>
          @endforeach
          
        </nav>
      </div>
    <hr>