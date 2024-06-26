<x-modal id="profile-photo-upload-modal">
    <x-slot name="title">
        <h5 class="modal-title" id="upload-profile-photo">Upload Photo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </x-slot>
    <x-slot name="body">
        <div class="row">
            <div class="col-12 text-center">
                <div id="cropie-demo" class="w-100">
                </div>
            </div>
            <div class="col-12 text-center">
                <strong style="font-size: 16px; font-weight: 400; margin-bottom: 15px; display: block;">
                    Choose image to crop:
                </strong>
                <div class="custom-file m-auto mt-3 mb-4" style="height: 45px; width: 175px;">
                    <input type="file" class="custom-file-input" id="upload_profile_files" name="profile_image"
                        accept=".png, .jpg, .jpeg">
                    <label class="custom-file-labels" for="upload_profile_files" style="font-size: 16px;">
                        <i class="simple-icon-cloud-upload">
                        </i> Choose a file...
                    </label>
                </div>
                <p class="upload_profile_file_error error mt-2  mb-0"></p>
                <br />
                <button type="submit" class="btn btn-primary upload-image" disabled="disabled">
                    Upload Image
                </button>
            </div>
        </div>
    </x-slot>
    <x-slot name="footer">
    </x-slot>
</x-modal>
