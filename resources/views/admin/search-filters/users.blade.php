<div class="row" id="search-filters">
    <div class="col-md-12 mb-3 user-wrap">
        <div class="card h-100">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-lg-3">
                        <input type="text" class="form-control" placeholder="Firstname" name="first_name"
                            id="first_name">
                    </div>
                    <div class="form-group col-lg-3">
                        <input type="text" class="form-control" placeholder="Lastname" name="last_name"
                            id="last_name">
                    </div>
                    <div class="form-group col-lg-3">
                        <input type="text" class="form-control" placeholder="Search by email" name="email"
                            id="email">
                    </div>
                    <div class="form-group col-lg-3">
                        <select id="roles-dropdown" class="form-control" data-width="100%" tabindex="-1"
                            aria-hidden="true" name="role_id">
                            <option hidden value="">
                                Select Role
                            </option>
                            @foreach ($roles as $key => $role)
                                <option value="{{ $role->id }}">
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- second row -->
                <div class="row">
                    <div class="form-group col-lg-3">
                        <div class="input-group">
                            <input type="text" class="date form-control" placeholder="Start date" name="start_date"
                                id="start_from">
                            <span class="input-group-text input-group-append input-group-addon">
                                <i class="simple-icon-calendar"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-3">
                        <div class="input-group">
                            <input type="text" class="form-control date" placeholder="End date" name="end_date"
                                id="end_to">
                            <span class="input-group-text input-group-append input-group-addon">
                                <i class="simple-icon-calendar"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <button type="button" class="btn btn-primary default  btn-lg mb-2 mb-lg-0 col-12 col-lg-auto"
                            id="search-button">
                            Search
                        </button>
                        <button type="button" class="btn btn-danger default  btn-lg mb-2 mb-lg-0 col-12 col-lg-auto"
                            id="reset-search">
                            Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
