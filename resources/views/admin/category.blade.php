
@include('admin.layouts.header');
<style>
  .page-item.active .page-link {
    z-index: 3;
    color: #fff;
    background-color: #A52834;
    border-color: #A52834;
}
</style>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Category</h1>
  </div>

  <div class="container-fluid">
  <a href="javascriprt:void()" id="addData" class="btn btn-secondary btn-sm mb-3">Add Category</a>
    <table class="table table-bordered data-table table-sm">
        <thead>
            <tr>
                <th width="10">No</th>
                <th>Name</th>
                <th>Status</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
</main>

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="javascript:void(0)" class="form" id="formCategori" method="POST" >
          <input type="hidden" name="id">
          <div class="form-group">
              <label>Name</label>
              <input type="text" value="" class="form-control" name="name" placeholder="Name">
          </div>
          <div class="form-group">
              <label>Status</label>
              <select name="status" id="status" class="form-control" >
                <option value="1">Active</option>
                <option value="0">Non Active</option>
              </select>
          </div>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-secondary btn-save" ></button>
      </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
var table;

  $(function () {
    
     table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.getCategory') }}",
        columns: [
           {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'statusCategory', name: 'statusCategory'},
            {data: 'action', name: 'action', orderable: false, searchable: true},
        ]
    });
    
  });

  $('#addData').on('click',function(){
        // action ='add';
        $('.modal-title').text('Add Category');
        $('.btn-save').text('Create');
        $('#myModal').modal('show');
        $('#formCategori').trigger("reset");
        $('input[name="id"]').val('');
        $('#description').text('');
    });
  
    function editData(params) {
       $('.btn-save').text('Update');
        $('.modal-title').text('Edit Category');
        $('#myModal').modal('show');
        $.ajax({
           url:"{{url('admin/getCategoryById')}}"+'/'+params,
           type:"GET",
           dataType:"JSON",
           headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend:function(){
                $('#formCategori').trigger("reset");
            },
            success:function(data){
                $('input[name="id"]').val(data.id);
                $('input[name="name"]').val(data.name);
                $('#status').val(data.status);
            },
       });
       
    }

    $('#formCategori').submit(function(){
        var action = $('input[name="id"]').val();
        if(action == ""){
            var url = "{{url('admin/save_category')}}";
        }else{
            var url = "{{url('admin/update_category')}}";
        }
       $.ajax({
           url:url,
           type:"POST",
           data: $('#formCategori').serialize(),
           headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
           success:function(data){
            $('#myModal').modal('hide');
            table.ajax.reload();
           },
       });
    });
    
    function deleteCategory(params) {
        if(confirm("Delete?")){
            $.ajax({
                url:"{{url('deleteCategory')}}/"+params,
                type:"GET",
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                success:function(data){
                    table.ajax.reload();
                },
            });
        }
    };

</script>

@include('admin.layouts.footer');