@extends('layouts.admin')
@push('styles')
<link rel="stylesheet" href="{{url('css/plugins/croppie.min.css')}}">
@endpush
@section('title') My Account @stop
@section('content')
<div class="container-fluid">
   <div class="row">
      <div class="col-12 pt-4">
         <h1>My Account</h1>
         <div class="separator mb-4"></div>
      </div>
   </div>
   @include('admin.common.loader')
   <div class="row mt-4">
      <div class="col-12 mb-4">
         <div class="card mb-4">
            <div class="row">
               <div class="col-md-3">
                  <div class="card-header tabs-header">
                     <ul class="nav nav-tabs vertical-tabs flex-column card-header-tabs " role="tablist">
                        <li class="nav-item">
                           <a class="nav-link active" id="basic-info-tab" data-toggle="tab" href="#basic-info" role="tab" aria-controls="basic-info" aria-selected="true">Basic</a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link" id="second-tab" data-toggle="tab" href="#second" role="tab" aria-controls="second" aria-selected="false">Reset Password</a>
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="col-md-9">
                  <div class="card-body" id="account-tab">
                     <div class="tab-content">
                        <div class="tab-pane fade show active" id="basic-info" role="tabpanel" aria-labelledby="basic-info-tab">
                           @include('admin.account.basic-info')
                        </div>
                        <div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab">
                           @include('admin.account.reset-password')
                        </div>
                        @include('admin.account.update-profile-pic')
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@push('extra_scripts')
<script src="{{url('js/plugins/croppie.js')}}"></script>
<script src="{{url('js/vendor/bootstrap-editable.min.js')}}"></script>
<script src="{{url('js/custom.js')}}"></script>
<script src="{{url('js/admin/modules/account.js')}}"></script>
@endpush