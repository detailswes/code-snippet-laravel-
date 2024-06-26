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
            <!-- remdered data= $roles -->
            @foreach($roles as $key => $role)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$role['name']}}</td>
                <td class="action-data d-flex">
                    <a class="action editRole" href="javascript:void(0)" data-role_id="{{ $role['id']}}" title="Edit Role"data-toggle="modal" data-backdrop="static" data-target="#role-modal" data-toggle="modal" data-backdrop="static"><i class="simple-icon-note"></i> </a>
                    <a href="javascript:void(0);" data-role_id="{{ $role['id']}}" class="delicon" data-toggle="modal" data-backdrop="static" data-target="#confirm-modal" data-toggle="modal" data-backdrop="static">
                        <i class="simple-icon-trash"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>