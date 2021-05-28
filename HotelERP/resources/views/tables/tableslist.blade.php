@include('admin.header')
     <div class="container-fluid">
     <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-gray-800">Table List</h1>   
        <a href="{{ url('addtables') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa fa-plus fa-sm text-white-50"></i> Add Table</a>
     </div>   
        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Table List</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example" width="100%" cellspacing="0">
                  <thead>
                    <tr>  
                      <th>No.</th>
                      <th>Title</th>
                      <th>QR Code Path</th>
                      <th>Table Type</th>
                      <th>Active</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                        <?php $count = ($result->currentpage()-1) * $result->perpage(); ?>
                        @foreach($result as $data)
                            <tr>
                                <td>{{ ++$count }}</td>
                                <td>{{ $data->name }}</td>
                                <td></td>
                                <td>{{ $data->table_type }}</td>
                                <td>{{ $data->active }}</td>
                                <td class="text-center"><a href="">
                                 <i class="fa fa-edit" aria-hidden="true"></i></a> 
                                 <a href="" 
                                  onclick="if (!confirm('Are you sure to delete this item?'))
                                  { return false }"><i class="fa fa-trash" aria-hidden="true"></i></a> </td>
                                
                            </tr>
                        @endforeach
                        </tbody>
                 </table>
            </div>     
            
@include('admin.footer')