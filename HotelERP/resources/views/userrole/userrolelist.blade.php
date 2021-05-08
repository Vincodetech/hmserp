@include('admin.header')
     <div class="container-fluid">
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-gray-800">User Role List</h1>   
        <a href="{{ url('adduserrolelist') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Add User Role</a>
     </div> 
     @if (Session::get('deleteCategoryInMsg'))
            <div class="alert alert-success">
                {{ Session::get('deleteCategoryInMsg') }}
            </div>
        @endif

        @if (Session::get('errDeleteCategoryInMsg'))
            <div class="alert alert-danger">
                {{ Session::get('errDeleteCategoryInMsg') }}
            </div>
        @endif  
        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">User Role List</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="users_roles_data" width="100%" cellspacing="0">
                  <thead>
                    <tr>  
                      <th>No.</th>
                      <th>Role Name</th>
                      <th>Active</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                 </table>
            </div>     
            <script type="text/javascript">
        $(document).ready(function(){

          fill_datatable();
            function fill_datatable()
            {
              var dataTable = $('#users_roles_data').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                  url: "{{ url('userrolelist') }}",
                  },
                  columns: [
                    {
                      data: 'DT_RowIndex',
                      name: 'DT_RowIndex'
                    },
                    {
                      data:'role',
                      name:'role'
                    },
                    {
                      data:'active',
                      name:'active'
                    },
                    {
                      data:'Action',
                      name:'Action'
                    }
                  ]
              });
            }
          });
      </script>       
      <script type="text/javascript">
      $(document).on('click','.delete',function(){
        var url = $(this).attr('url');
        if(confirm("Are you sure you want to delete this item?")){
          window.location.href = url
        }
        else{
          return false;
        }
      });
    </script>
@include('admin.footer')