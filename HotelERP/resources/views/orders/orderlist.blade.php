@include('admin.header')
     <div class="container-fluid">
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-gray-800">Order List</h1>   
        <a href="{{ url('#') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Add Order</a>
     </div>   
        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Order List</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="orders_data" width="100%" cellspacing="0">
                  <thead>
                    <tr>  
                      <th>No.</th>
                      <th>Item Name</th>
                      <th>Order Type</th>
                      <th>Table</th>
                      <th>Order ID</th>
                      <th>Order Status</th>
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
              var dataTable = $('#orders_data').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                  url: "{{ url('orderlist') }}",
                  },
                  columns: [
                    {
                      data: 'DT_RowIndex',
                      name: 'DT_RowIndex'
                    },
                    {
                      data:'item_id',
                      name:'item_id'
                    },
                    {
                      data:'order_type',
                      name:'order_type'
                    },
                    {
                      data:'table_id',
                      name:'table_id'
                    },
                    {
                      data:'orderid',
                      name:'orderid'
                    },
                    {
                      data:'order_status',
                      name:'order_status'
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