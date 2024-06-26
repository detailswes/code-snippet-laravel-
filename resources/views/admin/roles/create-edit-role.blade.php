 <x-modal id="role-modal" direction="modal-right">
     <x-slot name=" title">Title</x-slot>
     <x-slot name="body">
         <form id="createUserRole">
             <div class="form-group form-row-parent row">
                 <input type="hidden" id="id" name="id" value="{{$roles->id ?? ''}}" />
                 <label class="col-lg-12 col-xl-12 col-form-label">Name</label>
                 <div class="col-lg-12 col-xl-12">
                     <input type="text" class="form-control" id="name" placeholder="Role Name" name="name" value="{{$roles->name ?? ''}}">
                 </div>
             </div>
             <div class="form-group form-row-parent">
                 <label class="col-form-label">Manage Permissions<em>*</em></label>
                 <input type="button" id="checkAll" class="btn btn-primary btn-sm" value="Check All" name="select_all">
                 <div class="clearfix"></div>
                 <div class="permissions-list">
                     @foreach($permissionListData as $permission)
                     <label class="col-form-label permissionName">
                         <strong>{{$permission->name}}</strong>
                     </label><br>
                     @foreach($permission->lists as $data)
                     @php
                     $selected = '';
                     @endphp
                     @isset($roles->permissionArray)
                     @if($roles->permissionArray && in_array($data->id ,$roles->permissionArray))
                     @php
                     $selected = 'checked=checked'
                     @endphp
                     @endif
                     @endisset
                     <div class="form-check">
                         <input class="form-check-input" type="checkbox" name="permissions" value="{{$data->id}}" data_id="{{$permission->id}}" data_name="{{$permission->name}}" {{$selected}}>
                         <label class="form-check-label" for="gridRadios1">
                             {{$data->name}}
                         </label>
                     </div>
                     @endforeach
                     @endforeach
                 </div>
                 <div class="permissions_error errors"></div>
             </div>
             <div class="form-row mt-4">
                 <div class="col-md-12">
                     <button type="submit" class="btn btn-primary default btn-lg mb-2 mb-sm-0 mr-2 col-12 col-sm-auto">Submit</button>
                 </div>
             </div>
         </form>
     </x-slot>
     <x-slot name="footer"></x-slot>
 </x-modal>
