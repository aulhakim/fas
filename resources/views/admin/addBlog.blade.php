

@include('admin.layouts.header');
<script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <h1 class="h2">{{$label}}</h1>
    </div>
    <div class="container-fluid">
  
<form class="form" action="{{url($action)}}" method="POST" enctype="multipart/form-data" >
    @csrf

    <input type="hidden" name="id" value="{{$blog_id}}">
    <label>Image</label>
    <div class="form-group">
        <input type="file"  name="image" placeholder="">
        <input type="hidden" name="image2" value="{{$image2}}">
    </div>
    <div class="form-group">
        <label>Title</label>
        <input type="text" value="{{$title}}" class="form-control" name="title"  placeholder="Title">
    </div>
    <div class="form-group">
        <label>Category</label>
        <select name="category_id" id="category_id" class="form-control" >
         @foreach ($category as $cat)
         <option value="{{$cat->id}}"  {{ $category_id == $cat->id ? 'selected' : '' }} >{{$cat->name}}</option>
         @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Short Description</label>
       <textarea name="short_description" class="form-control" cols="30" rows="150" style="height:80px">{{$short_description}}</textarea>
    </div>
    <div class="form-group">
        <label>Content</label>
       <textarea name="content" class="form-control" id="editor" cols="30" rows="150" style="height:80px">{{$content}}</textarea>
    </div>
    <div class="form-group">
        <label>Status</label>
        <select name="status" id="status" class="form-control" >
          <option value="1" {{ $status == '1' ? 'selected' : '' }}>Active</option>
          <option value="0" {{ $status == '0' ? 'selected' : '' }}>Non Active</option>
        </select>
    </div>
 
</div>
<div class="modal-footer">
  <button type="submit" class="btn btn-secondary btn-save" >Save</button>
</div>
</form>

</div>

</main>

<script>
        ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );

</script>
<style>
    .ck-editor__editable {
    min-height: 200px;
}
</style>
@include('admin.layouts.footer');