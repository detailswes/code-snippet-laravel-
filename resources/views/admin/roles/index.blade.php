@php
$loggedInUser = auth()->user();
@endphp
@extends('layouts.admin')
@section('title') Roles @stop
@section('content')
<div class="container-fluid">
   @include('admin.roles.roles-listing')
</div>
@endsection
@push('extra_scripts')
  <script src="{{ url('js/admin/modules/roles.js') }}"></script>
@endpush
