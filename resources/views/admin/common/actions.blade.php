@php
$loggedInUser = auth()->user();
@endphp
<div>
    @if ($loggedInUser->can($prefix . '_edit'))
        <a class="action2 editData" href="javascript:void(0);" data-toggle="modal" data-backdrop="static"
            data-target="#edit-modal" data-id="{{ $model->id }}" data-bug_id="{{ $model->id }}"
            title="Edit {{ $iconTitle ?? 'User' }}">
            <i class="simple-icon-note"></i>
        </a>
    @endif
    @if ($loggedInUser->can($prefix . '_listing'))
        @if (!isset($hideView))
            <a class="action2 viewData" href="javascript:void(0)" data-toggle="modal" data-backdrop="static"
                data-target="#view-modal" data-id="{{ $model->id }}" data-bug_id="{{ $model->id }}"
                title="View User">
                <i class="simple-icon-eye"> </i>
            </a>
        @endif
    @endif
    @if ($loggedInUser->can($prefix . '_delete'))
        <a class="action2 deleteData" href="javascript:void(0)" data-toggle="modal" data-backdrop="static"
            data-target="#confirm-modal" data-id="{{ $model->id }}" data-bug_id="{{ $model->id }}"
            title="Delete {{ $iconTitle ?? 'User' }}">
            <i class="simple-icon-trash"></i>
        </a>
    @endif
</div>
