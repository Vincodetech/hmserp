<h1>Dashboard Page</h1>
@php
$uname = Session::get('admin_name');
echo $uname;
@endphp