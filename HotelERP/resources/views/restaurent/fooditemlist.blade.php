@include('admin.header')
     <div class="container-fluid">
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-gray-800">Food Item List</h1>   
        <a href="{{ url('addfooditem') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Add Food Item</a>
     </div> 
     @if (Session::get('deleteItemInMsg'))
            <div class="alert alert-success">
                {{ Session::get('deleteItemInMsg') }}
            </div>
        @endif

        @if (Session::get('errDeleteItemInMsg'))
            <div class="alert alert-danger">
                {{ Session::get('errDeleteItemInMsg') }}
            </div>
        @endif  
        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Food Item List</h6> 
                <div class="col-lg-12 col-lg-offset-3">
                 
                  <label>Food Category:</label>   &nbsp;                
                  <select name="dropdown" id="filter_food_category">  &nbsp;
                    <option value="">Select</option>
                    @foreach($allcategory as $data)
                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                    @endforeach 
                  </select> &nbsp;
                  <label>Item Type:</label> &nbsp;
                  <select name="dropdown1" id="filter_item_type"> &nbsp;
                    <option value="">Select</option>
                    <option value="restaurant">Restaurant</option>
                    <option value="cafe">Cafe</option> 
                  </select> &nbsp; &nbsp; &nbsp;
                  <button type="button" name="filter" id="filter" class="btn btn-info">Filter</button> &nbsp; &nbsp; &nbsp;
                  <button type="button" name="reset" id="reset" class="btn btn-danger">Reset</button>
                  <a class="btn btn-success" href="{{ url('fooditemexport') }}" style="float: right;">Export</a>                 
                </div>                           
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="fooditem_data" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Item Image</th>
                      <th>Item Name</th>
                      <th>Category</th>
                      <th>Item Type</th>
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
            function fill_datatable(filter_food_category = '', filter_item_type = '')
            {
              var dataTable = $('#fooditem_data').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                  url: "{{ url('fooditem') }}",
                  data:{filter_food_category:filter_food_category, filter_item_type:filter_item_type}
                  },
                  columns: [
                    {
                      data: 'DT_RowIndex',
                      name: 'DT_RowIndex'
                    },
                    {
                      data:'item_image',
                      name:'item_image'
                    },
                    {
                      data:'name',
                      name:'name'
                    },
                    {
                      data:'category_id',
                      name:'category_id'
                    },
                    {
                      data:'item_type',
                      name:'item_type'
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
            $('#filter').click(function(){
              var filter_food_category = $('#filter_food_category').val();
              var filter_item_type = $('#filter_item_type').val();

              if(filter_food_category != '' && filter_item_type != '')
              {
                  $('#fooditem_data').DataTable().destroy();
                  fill_datatable(filter_food_category, filter_item_type);
              }
              else
              {
                  alert('Please Select Both Filter Option');
              }
            });
            $('#reset').click(function(){
              $('#filter_food_category').val('');
              $('#filter_item_type').val('');
              $('#fooditem_data').DataTable().destroy();
              fill_datatable();
            });
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
    <!-- <script type="text/javascript">
    $(document).ajaxStop(function () {
        $('.toggle_status').on('click', function (e) {
            var is_checked = false
            if ($(this).is(':checked')) {
                is_checked = true;
            }
            $.ajax({
                type: 'GET',
                url: "{{ url('fooditem') }}", // use proper route to system-functions here
                async: true,
                data: {
                    is_checked: is_checked,
                    id: {{ $data->id }}
                },
                success: function (result) {
                    alert('Toggle successfull'); // use proper alert message here
                    e.stopImmediatePropagation();
                    return false;
                }
            });
        });
    });
  </script> -->
  <script>
    
  $(function() {
    $('#toggle-demo').bootstrapToggle();
  });
  </script>
@include('admin.footer')