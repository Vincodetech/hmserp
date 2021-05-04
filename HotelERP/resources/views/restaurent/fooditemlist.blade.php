@include('admin.header')
     <div class="container-fluid">
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-gray-800">Food Item List</h1>   
        <a href="{{ url('addfooditem') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Add Food Item</a>
     </div>   
        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Food Item List</h6> 
                <div class="col-lg-12 col-lg-offset-3">
                  <label>Filter:</label> &nbsp;
                  <input id ="search" type="text" name="search"
                                     placeholder="Search Here..."> &nbsp;
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
                  </select> 
                  <button type="button" name="filter" id="filter" class="btn btn-info">Filter</button>
                  <button type="button" name="reset" id="reset" class="btn btn-default">Reset</button>
                  <a class="btn btn-success" href="{{ url('export') }}">Export</a>                 
                </div>                           
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="fooditem_data" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Item Image</th>
                      <th>Item Name</th>
                      <th>Category</th>
                      <th>Item Type</th>
                      <th>Active</th>
                    </tr>
                  </thead>
                  <tbody>
                                <!-- <td class="text-center"><a href="{{ url('viewfooditem/'.$data->id) }}">
                                 <i class="fa fa-eye" aria-hidden="true"></i></a> 
                                 <a href="{{ url('updatefooditem/'.$data->id) }}">
                                 <i class="fa fa-edit" aria-hidden="true"></i></a>
                                 <a href="{{ url('deletefooditem/'.$data->id) }}" 
                                  onclick="if (!confirm('Are you sure to delete this item?'))
                                  { return false }"><i class="fa fa-trash" aria-hidden="true"></i></a> </td> -->
                                
                            </tr>
                        
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
                  url:"{{ route('food.item') }}",
                  data:{filter_food_category:filter_food_category, filter_item_type:filter_item_type}
                  },
                  columns: [
                    {
                      data:'Item Image',
                      name:'item_image'
                    },
                    {
                      data:'Item Name',
                      name:'name'
                    },
                    {
                      data:'Category',
                      name:'category_id'
                    },
                    {
                      data:'Item Type',
                      name:'item_type'
                    },
                    {
                      data:'Active',
                      name:'active'
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
                  alert('Select Both Filter Option');
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
@include('admin.footer')