
@include('admin.layouts.header');
@php
    use Illuminate\Support\Facades\Auth;
@endphp
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h4">Selamat datang {{Auth::user()->name}}</h1>

        </div>
        <h2></h2>
      </main>
 @include('admin.layouts.footer');
