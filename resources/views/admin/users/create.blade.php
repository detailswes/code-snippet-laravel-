<x-modal id="user-modal" direction="modal-right">
    <x-slot name="title">Title</x-slot>
    <x-slot name="body">
        <form id="create-form">
            <div class="form-group form-row-parent row">
                <label class="col-lg-12 col-xl-12 col-form-label">First Name
                    <em>*</em>
                </label>
                <div class="col-lg-12 col-xl-12">
                    <input type="text" class="form-control" placeholder="First Name" name="first_name"
                        value="{{ $user->first_name ?? '' }}">
                    <span class="text-danger error first_name-error"></span>
                </div>
            </div>
            <div class="form-group form-row-parent row">
                <label class="col-lg-12 col-xl-12 col-form-label">Last Name
                    <em>*</em>
                </label>
                <div class="col-lg-12 col-xl-12">
                    <input type="text" class="form-control" placeholder="Last Name" name="last_name"
                        value="{{ $user->last_name ?? '' }}">
                    <span class="text-danger error last_name-error"></span>
                </div>
            </div>
            <div class="form-group form-row-parent row">
                <label class="col-lg-12 col-xl-12 col-form-label">Email <em>*</em></label>
                <div class="col-lg-12 col-xl-12">
                    <input type="text" class="form-control" placeholder="Email" name="email"
                        value="{{ $user->email ?? '' }}">
                    <span class="text-danger error email-error"></span>
                </div>
            </div>
            @if (!$user)
                <div class="form-group form-row-parent row">
                    <label class="col-lg-12 col-xl-12 col-form-label">Password <em>*</em> </label>
                    <div class="col-lg-12 col-xl-12">
                        <input type="password" class="form-control" placeholder="Password" name="password">
                        <span class="text-danger error password-error"></span>
                    </div>
                </div>
            @endif
            <div class="form-group form-row-parent row">
                <label class="col-lg-12 col-xl-12 col-form-label">Role <em>*</em> </label>
                <div class="col-lg-12 col-xl-12">
                    <select class="form-control select2-single" data-width="100%" name="role_id" id="role_id"
                        value="{{ $user->role_id ?? '' }}">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}"
                                {{ $role->id == ($user->role_id ?? '') ? 'selected' : '' }}>{{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger error role_id-error"></span>
                </div>
            </div>
            <div class="form-row mt-4">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary default btn-lg mb-2 mb-sm-0 mr-2 col-12 col-sm-auto"
                        id="submit-button">
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </x-slot>
    <x-slot name="footer">
    </x-slot>
</x-modal>
