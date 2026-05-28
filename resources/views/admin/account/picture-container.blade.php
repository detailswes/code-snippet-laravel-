<div class="col-md-3 profile-picture" id="picture-container">
    <div class="picture-container">
        <div class="picture">
            <img src="{{ Auth()->user()->fullProfileImagePath() }}" class="picture-src" id="profile-picture"
                alt="Profile Picture" title=""
                data-original-value="{{ Auth()->user()->fullOriginalProfileImagePath() }}" data-toggle="modal"
                data-target="#profile-photo-upload-modal">
        </div>
    </div>
</div>
