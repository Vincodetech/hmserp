@include('admin.header')
     <div class="container-fluid">
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-gray-800">Users List</h1>   
        <a href="{{ url('adduserslist') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Add Users</a>
     </div>   
        <div class="card shadow mb-4">
            <div class="card-header py-2">
              <h6 class="m-0 font-weight-bold text-primary">Users List</h6>
              <a class="btn btn-success" href="{{ url('usersexport') }}" style="float: right;">Export</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="users_data" width="100%" 
                cellspacing="0">
                  <thead>
                    <tr>  
                      <th>No.</th>
                      <th>User Name</th>
                      <th>User Email</th>
                      <th>User Phone No.</th>
                      <th>User Role</th>
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
              var dataTable = $('#users_data').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                  url: "{{ url('userslist') }}",
                  },
                  columns: [
                    {
                      data: 'DT_RowIndex',
                      name: 'DT_RowIndex'
                    },
                    {
                      data:'user_name',
                      name:'user_name'
                    },
                    {
                      data:'email',
                      name:'email'
                    },
                    {
                      data:'phone',
                      name:'phone'
                    },
                    {
                      data:'user_role',
                      name:'user_role'
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
@include('admin.footer')