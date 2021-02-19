@include('admin.header')

        @if (Session::get('deleteStockInMsg'))
            <div class="alert alert-success">
                {{ Session::get('deleteStockInMsg') }}
            </div>
        @endif

        @if (Session::get('errDeleteStockInMsg'))
            <div class="alert alert-danger">
                {{ Session::get('errDeleteStockInMsg') }}
            </div>
        @endif
        <form role="form" action="{{ url('deletefoodcategory') }}" method="post">
@include('admin.footer')                    