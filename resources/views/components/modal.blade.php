<div class="modal fade {{ $direction ?? '' }}" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $id }}-title" aria-modal="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog {{ $centerClass ?? ''}} {{ $size ?? '' }}" role="document">
        <div class="modal-content">
            @if ($show_header)
            <div class="modal-header py-1">
                @if (isset($headerButtons))
                {{ $headerButtons }}
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="modal-body">
                {{ $body }}
            </div>
            @if ($footer->isNotEmpty())
            <div class="modal-footer">
                {{ $footer }}
            </div>
            @endif
        </div>
    </div>
</div>