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
                  <select name="dropdown" id="food_category">  &nbsp;
                    <option value="">Select</option>
                    @foreach($allcategory as $data)
                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                    @endforeach 
                  </select> &nbsp;
                  <label>Item Type:</label> &nbsp;
                  <select name="dropdown1" id="item_type"> &nbsp;
                    <option value="">Select</option>
                    <option value="restaurant">Restaurant</option>
                    <option value="cafe">Cafe</option> 
                  </select>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                  <a class="btn btn-success" href="{{ url('export') }}">Export</a>                 
                </div>                           
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Item Image</th>
                      <th>Item Name</th>
                      <th>Category</th>
                      <th>Item Type</th>
                      <th>Active</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                        <?php $count = ($result->currentpage()-1) * $result->perpage(); ?>
                        @foreach($result as $data)
                            <tr>
                                <td>{{ ++$count }}</td>
                                <td>
                                    <img src="{{ asset('/storage/images/'.$data->item_image) }}"
                                     alt="Image" width="50"/>
                                </td>
                                <td>{{ $data->name }}</td>
                                <td><?php
                                      $sql = DB::table('food_category')->where('id',$data->category_id)->first();
                                      echo $sql->name;
                                    ?> </td>
                                <td>{{ $data->item_type }}</td>
                                <td>{{ $data->active }}</td>
                                <td class="text-center"><a href="{{ url('viewfooditem/'.$data->id) }}">
                                 <i class="fa fa-eye" aria-hidden="true"></i></a> 
                                 <a href="{{ url('updatefooditem/'.$data->id) }}">
                                 <i class="fa fa-edit" aria-hidden="true"></i></a>
                                 <a href="{{ url('deletefooditem/'.$data->id) }}" 
                                  onclick="if (!confirm('Are you sure to delete this item?'))
                                  { return false }"><i class="fa fa-trash" aria-hidden="true"></i></a> </td>
                                
                            </tr>
                        @endforeach
                        </tbody>
                 </table>
            </div>     
            <div class="card-footer" style="overflow">
              {{ $result->links() }}
            </div>     
<!-- <nav aria-label="...">
  <ul class="pagination">
    <li class="page-item disabled">
      <a class="page-link" href="" tabindex="-1">Previous</a>
    </li>
    <li class="page-item active"><a class="page-link" href="">1 <span class="sr-only">(current)</span></a></li>
    <li class="page-item">
      <a class="page-link" href="">2 </a>
    </li>
    <li class="page-item"><a class="page-link" href="">3</a></li>
    <li class="page-item">
      <a class="page-link" href="">Next</a>
    </li>
  </ul>
</nav> -->
@include('admin.footer')