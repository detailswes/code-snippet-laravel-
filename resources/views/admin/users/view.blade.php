<x-modal id="view-modal" direction="modal-right">
    <x-slot name="title">Title </x-slot>
    <x-slot name="headerButtons">
        @if (Auth::user()->can('user_edit'))
            <a class="action2 editData" href="javascript:void(0)" data-dismiss="modal" data-id="{{ $user->id }}"
                data-bug_id="{{ $user->id }}" title="Edit User" style="color: #646464;">
                <i class="simple-icon-note" style="font-size:16px;"></i>
            </a>
        @endif
        @if ($user->previous_id)
            <a class="ml-4 mr-4 prev-next action2 viewData" href="javascript:void(0)" data-id="{{ $user->previous_id }}"
                data-bug_id="{{ $user->previous_id }}" title="Previous User">
                <img class="previousImg imageSize" src="{{ url('img/arrow-circle-left-solid.svg') }}">
            </a>
        @endif
        @if ($user->next_id)
            <a class="ml-5 prev-next action2 viewData" href="javascript:void(0)" data-id="{{ $user->next_id }}"
                data-bug_id="{{ $user->next_id }}" title="Next User">
                <img class="nextImg imageSize" src="{{ url('img/arrow-circle-right-solid.svg') }}">
            </a>
        @endif
    </x-slot>
    <x-slot name="body">
        <div class="align-items-center d-flex justify-content-start ">
            <p>
                <strong>First Name :</strong> {{ $user->first_name }}
            </p>
        </div>
        <div class="align-items-center d-flex justify-content-start ">
            <p>
                <strong>Last Name :</strong> {{ $user->last_name }}
            </p>
        </div>
        <div class="align-items-center d-flex justify-content-start ">
            <p>
                <strong>Email :</strong> {{ $user->email }}
            </p>
        </div>
        <div class="align-items-center d-flex justify-content-start ">
            <p>
                <strong>Role :</strong> {{ $user->role->name }}
            </p>
        </div>
        <div class="align-items-center d-flex justify-content-start ">
            <p>
                <strong>Status :</strong> {{ $user->status == 1 ? 'Enabled' : 'Disabled' }}
            </p>
        </div>
    </x-slot>
    <x-slot name="footer">
    </x-slot>
</x-modal>
