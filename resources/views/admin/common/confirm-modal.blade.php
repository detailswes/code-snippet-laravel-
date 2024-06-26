<x-modal id="confirm-modal" centerClass="modal-dialog-centered">
    <x-slot name="title">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </x-slot>
    <x-slot name="body">
        {{ $data['body_text'] }}
    </x-slot>
    <x-slot name="footer">
        <button type="button" data-dismiss="modal" class="btn btn-light mb-1">No</button>
        <button type="submit" data-dismiss="modal" class="btn {{ $data['left_button_class'] }} delete_bug" data-id="{{ $data['id'] }}" id="{{ $data['left_button_id'] }}">{{ $data['left_button_name'] }}</button>
    </x-slot>
</x-modal>
