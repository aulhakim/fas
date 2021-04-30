
@include('admin.layouts.header');

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Blog</h1>
  </div>

  <div class="container-fluid">
  <a href="{{ url('admin/blog/add') }}"  class="btn btn-secondary btn-sm mb-3">Add Blog</a>
    <table class="table table-bordered data-table table-sm">
        <thead>
            <tr>
                <th width="10">No</th>
                <th width="20">Image</th>
                <th>Title</th>
                <th>Short Desc</th>
                <th>Created By</th>
                <th>Status</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>


</main>


<script type="text/javascript">
var table;

  $(function () {
    
     table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('admin/getblog') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            { data: 'image', name: 'image',
                 render: function( data, type, full, meta ) {
                        return "<img src=\"/assets/image/blog_thumb/" + data + "\" height=\"50\"/>";
                    }
                 },
            {data: 'title', name: 'title'},
            {data: 'short_description', name: 'short_description'},
            {data: 'name', name: 'name'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });

  function deleteBlog(params) {
        if(confirm("Delete?")){
            $.ajax({
                url:"{{url('admin/blog/delete')}}/"+params,
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