@php
$loggedInUser = auth()->user();
@endphp
<div class="row">
    <div class="col-12 pt-4" id="create">
        <h1>Roles</h1>
        @if($loggedInUser->can('roles_create'))
        <span class="float-right balance ml-2 create">
            <a id="create_role" class="btn btn-primary" href="#" data-toggle="modal" data-backdrop="static" data-target="#role-modal">Create a Role</a>
        </span>
        @endif
        <div class="separator mb-5"></div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive" id="mainData">
                    <table class="table table-hover table-bordered">
                        <thead class="bg-primary">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- $roles=main data fetched  -->
                            @foreach($roles as $key => $role)
                            <tr class="role-row">
                                <td>{{++$key}}</td>
                                <td>{{$role->name}}</td>
                                <td class="action-data d-flex">
                                    @if($loggedInUser->can('roles_edit'))
                                    <a class="action editRole" href="javascript:void(0)" data-target="#role-modal" data-id="{{$role->id}}" data-role_id="{{ $role->id }}" title="Edit Role">
                                        <i class="simple-icon-note"></i>
                                    </a>
                                    @endif
                                    @if($loggedInUser->can('roles_delete'))
                                    <a class="action2 deleteRole" href="javascript:void(0)" data-toggle="modal" data-backdrop="static" data-target="#confirm-modal" data-id="{{$role->id}}" data-bug_id="{{$role->id}}" title="Delete Role">
                                        <i class="simple-icon-trash"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>