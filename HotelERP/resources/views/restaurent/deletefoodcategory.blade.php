@include('admin.header')

        @if (Session::get('deleteCategoryInMsg'))
            <div class="alert alert-success">
                {{ Session::get('deleteCategoryInMsg') }}
            </div>
        @endif

        @if (Session::get('errDeleteCategoryInMsg'))
            <div class="alert alert-danger">
                {{ Session::get('errDeleteCategoryInMsg') }}
            </div>
        @endif
        <form role="form" action="{{ url('deletefoodcategory') }}" method="post">
@include('admin.footer')                    