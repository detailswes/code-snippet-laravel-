<div class="custom-switch custom-switch-primary custom-switch-small">
    <input class="custom-switch-input" id="switch_{{ $model->id }}" type="checkbox" data-id="{{ $model->id }}"
        @if ($model->status) checked @endif>
    {{-- {{ Str::contains($routeName, 'blogs') ? 'nav-dropdown-item-active' : '' }} --}}
    <label class="custom-switch-btn" for="switch_{{ $model->id }}">
    </label>
</div>
