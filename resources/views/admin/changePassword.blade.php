
@include('admin.layouts.header')
@php
    $id = Auth::user()->id;
@endphp
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">Change Password</h1>
    </div>
    <div class="container-fluid">

        @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif
        @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
  
<form class="form" action="{{url('admin/do-change-password')}}" method="POST">
    @csrf

    <input type="hidden" name="id" value="{{$id}}">
   
    <div class="form-group">
        <label>Old Password</label>
        <input type="password" value="" class="form-control" name="old_pass"  placeholder="Old Password" required>
    </div>
    <div class="form-group">
        <label>New Password</label>
        <input type="password" value="" class="form-control" name="new_pass"  placeholder="New Password" required>
    </div>
    <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" value="" class="form-control" name="conf_pass"  placeholder="Confirm Password" required>
    </div>
    
</div>
<div class="modal-footer">
  <button type="submit" class="btn btn-secondary btn-save" >Save</button>
</div>
</form>

</div>

</main>
@include('admin.layouts.footer')