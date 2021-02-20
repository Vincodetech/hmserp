@include('admin.header')
<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                <div class="d-sm-flex align-items-center justify-content-between mb-5">
                   Add Food Item Information
                </div>
                
                {{--{{Session::get('roleMsg')}}--}}
                @if (Session::get('roleSccssMsg'))
                    <div class="alert alert-success">
                        {{ Session::get('roleSccssMsg') }}
                    </div>
                @endif

                @if (Session::get('roleErrMsg'))
                    <div class="alert alert-danger">
                        {{ Session::get('roleErrMsg') }}
                    </div>
                @endif
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-lg-offset-3">
                            <form role="form" action="{{ url('postfooditem') }}" method="post" 
                            enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <script>
                                    function copyText2() {
                                        var finalval = "";
                                        textBox2 = document.getElementById("name");
                                        message2 = document.getElementById("slug");
                                        finalval += textBox2.value.replace(/ /g, '-')
                                        message2.value = finalval;
                                    }
                                </script>
                                <div class="form-group">
                                    <label>Item Name</label>
                                    <input id="name" class="form-control" type="text" name="name"
                                    onkeyUp="copyText2()" placeholder="Enter Item Name"
                                           autofocus
                                           required>
                                </div>
                                <div class="form-group">
                                    <label>Slug</label>
                                    <input id ="slug" class="form-control" type="text" name="slug"
                                     placeholder="Enter Slug Name"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Item Image</label>
                                    <input type="file" name="item_image">
                                </div>    
                                <div class="form-group">
                                    <label>Food Category</label>
                                    <select class="form-control" name="category_id">
                                        <option value="none">Select</option>
                                        @foreach($allcategory as $data)
                                        <option value="{{ $data->id }}">{{ $data->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" id="description" name="description"
                                     placeholder="Enter Description"></textarea>
                                     <script type="text/javascript">
                                        CKEDITOR.replace( 'description' );
                                    </script>
                                </div>
                                <div class="form-group">
                                    <label>Unit</label>
                                    <input class="form-control" type="text" name="unit"
                                     placeholder="Enter Unit"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Price</label>
                                    <input class="form-control" type="text" name="price"
                                     placeholder="Enter Price"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input class="form-control" type="text" name="quantity"
                                     placeholder="Enter Quantity"
                                           autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Item Type</label>
                                    <select class="form-control" name="item_type">
                                        <option value="">Select</option>
                                        <option value="restaurant">Restaurant</option>
                                        <option value="cafe">Cafe</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Active</label>
                                    <input type="checkbox" name="active" value="1">
                                </div>
                                <button type="submit" class="btn btn-primary"> Add Food Item</button>
                            </form>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        
        <!-- /.col-lg-12 -->
        
    </div>
       
</div>
@include('admin.footer')    