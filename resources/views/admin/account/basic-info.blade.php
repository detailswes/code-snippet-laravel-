<form class="profileform" id="edit-account-info">
    <div class="profile-editicon">
        <i class="simple-icon-note"></i>
        <i class="simple-icon-close"></i>
    </div>
    <div class="row align-items-center">
        @include('admin.account.picture-container')
        <div class="col-md-9 profile-info">
            <div class="profile-information">
                <div class="form-group row align-items-center">
                    <label class="col-lg-3 col-xl-2 col-form-label">
                      First Name
                    </label>
                    <div class="col-lg-9 col-xl-10 d-flex col-form-input">
                        <a href="javascript:void(0);" class="" data-type="text">
                        {{$user->first_name}}
                        </a>
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label class="col-lg-3 col-xl-2 col-form-label">
                    Last Name
                    </label>
                    <div class="col-lg-9 col-xl-10 d-flex col-form-input">
                        <a href="javascript:void(0);" class="" data-type="text">
                          {{$user->last_name}}
                        </a>
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label class="col-lg-3 col-xl-2 col-form-label">
                      Email
                    </label>
                    <div class="col-lg-9 col-xl-10 d-flex col-form-input">
                        <a href="javascript:void(0);" class="" data-type="text">
                          {{$user->email}}
                        </a>
                    </div>
                </div>
            </div>
            <div class="profileeditform">
                <div class="form-group row align-items-center">
                    <label class="col-lg-3 col-xl-2 col-form-label">First Name*</label>
                    <div class="col-lg-9 col-xl-10 col-form-input">
                        <input
                            type="text"
                            class="form-control"
                            value="{{$user->first_name}}"
                            name="first_name"
                            data-original-value="{{$user->first_name}}"
                            >
                    </div>
                    <span class="text-danger error first_name_error"></span>
                </div>
                <div class="form-group row align-items-center">
                    <label class="col-lg-3 col-xl-2 col-form-label">Last Name*</label>
                    <div class="col-lg-9 col-xl-10 col-form-input">
                        <input
                            type="text"
                              class="form-control"
                              value="{{$user->last_name}}"
                              name="last_name"
                              data-original-value="{{$user->last_name}}"
                            >
                    </div>
                    <span class="text-danger error last_name_error"></span>
                </div>
                <div class="form-group row align-items-center">
                    <label class="col-lg-3 col-xl-2 col-form-label">Email</label>
                    <div class="col-lg-9 col-xl-10 col-form-input">
                        <input
                              type="text"
                              class="form-control"
                              value="{{$user->email}}"
                              data-original-value="{{$user->email}}"
                              name="email"
                              readonly
                            >
                    </div>
                    <span class="text-danger error email_error"></span>
                </div>
                <div class="form-row mt-4">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary default btn-lg mb-1 mr-2">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
