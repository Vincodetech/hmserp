@include('admin.header')
     <div class="container-fluid">
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-gray-800">Billing</h1>   
        <a href="{{ url('addbilling') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Create Bill</a>
     </div>   
        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Billing</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="billing_data" width="100%" cellspacing="0">
                  <thead>
                    <tr>  
                      <th>No.</th>
                      <th>Customer Name</th>
                      <th>Customer Phone</th>
                      <th>Item Name</th>
                      <th>Bill No.</th>
                      <th>Bill Date</th>
                      <th>Grand Total</th>
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
              var dataTable = $('#billing_data').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                  url: "{{ url('billinglist') }}",
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
                      data:'phone',
                      name:'phone'
                    },
                    {
                      data:'name',
                      name:'name'
                    },
                    {
                      data:'bill_no',
                      name:'bill_no'
                    },
                    {
                      data:'bill_date',
                      name:'bill_date'
                    },
                    {
                      data:'grand_total',
                      name:'grand_total'
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