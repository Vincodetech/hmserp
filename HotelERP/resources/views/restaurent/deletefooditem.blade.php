@include('admin.header')

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
        <form role="form" action="{{ url('deletefooditem') }}" method="post">
@include('admin.footer')                    