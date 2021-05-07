@include('admin.header')
     <div class="container-fluid">
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-gray-800">Food Category List</h1>   
        <a href="{{ url('addfoodcategory') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Add Food Category</a>
     </div>   
        <div class="card shadow mb-4">
            <div class="card-header py-2">
              <h6 class="m-0 font-weight-bold text-primary">Food Category List</h6>
              <a class="btn btn-success" href="{{ url('foodcategoryexport') }}" style="float: right;">Export</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="foodcategory_data" width="100%" cellspacing="0">
                  <thead>
                    <tr>  
                      <th>No.</th>
                      <th>Image</th>
                      <th>Category Name</th>
                      <th>Type</th>
                      <th>Quantity</th>
                      <th>Status</th>
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
              var dataTable = $('#foodcategory_data').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                  url: "{{ url('foodcategory') }}",
                  },
                  columns: [
                    {
                      data: 'DT_RowIndex',
                      name: 'DT_RowIndex'
                    },
                    {
                      data:'category_image',
                      name:'category_image'
                    },
                    {
                      data:'name',
                      name:'name'
                    },
                    {
                      data:'category_type',
                      name:'category_type'
                    },
                    {
                      data:'category_quantity',
                      name:'category_quantity'
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