$uploadCrop = $('#cropie-demo').croppie({
  enableExif: true,
  viewport: {
    width: 200,
    height: 200,
    type: 'circle'
  },
  boundary: {
    width: 300,
    height: 300
  }
});

$('#upload_profile_files').on('change', function (e) {
  validate(this.value);
  var reader = new FileReader();
  reader.onload = function (e) {
    $uploadCrop.croppie('bind', {
      url: e.target.result
    }).then(function () {
      $('.cr-image').css('display', 'block');
    });
  }
  reader.readAsDataURL(this.files[0]);
});

$('.upload-image').on('click', function (ev) {
  $uploadCrop.croppie('result', {
    type: 'canvas',
    size: 'viewport'
  }).then(function (resp) {
    var originalImage = $("#upload_profile_files").prop("files")[0];
    var formData = new FormData();
    formData.append("image", resp);
    formData.append("original_image", originalImage);
    toggleLoader('block');
    $.ajax({
      url: base_url + '/account/update/profile/image',
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      cache: false,
      success: function (data) {
        toggleLoader('none');
        if (data.success) {
          $('#profile-photo-upload-modal').modal('hide');
          toastr.success(data.message);
          $('#picture-container').empty().html(data.html);
          $(".profile-information").show();
          $(".profile-editicon .simple-icon-note").show('');
          toggleTabs();
          updateNavBar(data.user);
        } else {
          toastr.error('Someting went wrong!');
        }
      }, error: function (err) {
        toggleLoader('none');
        console.log(err);
      }
    });
  });
});

$(document).ready(function () {
  toggleTabs();
});

$(document).on('submit', '#edit-account-info', function (e) {
  event.preventDefault();
  toggleLoader('block');
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: base_url + '/account/update',
    data: formData,
    dataType: 'json',
    processData: false,
    contentType: false,
    success: function (data) {
      toggleLoader('none');
      if (data.status == 'success') {
        toastr.success(data.message);
        $('#basic-info').empty().html(data.html);
        toggleTabs();
        updateNavBar(data.user);
      }
    },
    error: function (err) {
      toggleLoader('none');
      if (err.status == 422) {
        var errors = JSON.parse(err.responseText);
        $('.errors').remove();
        $.each(errors.errors, function (i, error) {
          var el = $(document).find('[name="' + i + '"]');
          el.after($('<span class="errors" style="color: red;">' + error[0] + '</span>'));
        });
      }
    }
  });
});

/* update password */

$(document).on('submit', '#reset-password', function (e) {
  event.preventDefault();
  var formData = new FormData(this);
  toggleLoader('block');
  $.ajax({
    type: "POST",
    url: base_url + '/account/password/reset',
    data: formData,
    dataType: 'json',
    processData: false,
    contentType: false,
    success: function (data) {
      if (data.status == 'success') {
        toastr.success(data.message);
        $('#reset-password :input').val('');
      }
      $('.errors').remove();
      toggleLoader('none');
    },
    error: function (err) {
      var errors = JSON.parse(err.responseText);
      toggleLoader('none');
      if (err.status == 422) {
        $('.errors').remove();
        $.each(errors.errors, function (i, error) {
          var el = $(document).find('[name="' + i + '"]');
          el.after($('<span class="errors" style="color: red;">' + error[0] + '</span>'));
        });
      } else if (err.status == 404) {
        toastr.error(errors.message);
      }
    }
  });
});


function toggleTabs() {
  $('.editable-field').editable();
  $(".profile-editicon .simple-icon-close , .profileeditform").hide();
  $(".profile-editicon i.simple-icon-note").click(function () {
    $(this).hide();
    $(".profileeditform :input").each(function (ele) {
      $(this).val($(this).data('originalValue'));
      $('.errors').remove();
    });
    $(".profile-editicon .simple-icon-close").show();
    $(".profileeditform").show();
    $(".profileeditform").css("width", "100%");
    $(".profile-information").hide();
  });
  $(".profile-editicon i.simple-icon-close").click(function () {
    $(this).hide();
    $(".profileeditform").hide();
    $(".profile-editicon .simple-icon-note").show('');
    $(".profileeditform").hide();
    $(".profile-information").show();
  });
}

$('.custom-file-input').change(function (e) {
  e.preventDefault();
  readURL(this);
});

/* read image url */
function readURL(input) {
  $('#user-image').css('display', 'block');
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#blah').attr('src', e.target.result);
    };
    reader.readAsDataURL(input.files[0]);
  }
}
// Validation File Uploads
function validate(file) {
  var ext = file.split(".");
  ext = ext[ext.length - 1].toLowerCase();
  var arrayExtensions = ["jpg", "jpeg", "png", "gif"];
  if (arrayExtensions.lastIndexOf(ext) == -1) {
    msg = "The upload profile file must be a file of type: jpeg, jpg, png, gif, jpg";
    $('.upload_profile_file_error').html(msg);
    $('.upload-image').attr('disabled', 'disabled');
    $("#upload_profile_files").val("");
  } else {
    $('.error').html('');
    $('.upload-image').removeAttr('disabled');
  }
}
$('[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  $(".profileeditform").hide();
  $(".profile-information").show();
  $('.errors').remove();
  $(".profile-editicon .simple-icon-note").show();
  $(".profile-editicon .simple-icon-close").hide();
});

$('#profile-photo-upload-modal').on('shown.bs.modal', function (e) {
  $uploadCrop.croppie('bind', {
    url: $('#profile-picture').data('originalValue'),
  }).then(function () {
    $('.upload-image').removeAttr('disabled');
  });
});

function updateNavBar(data) {
  $('#full-user-name').html(data.full_name);
  $('#profile_image').attr('src', `/storage/${data.profile_image_path}`);
}

$('#basic-info-tab').click(function () {
  $('#reset-password :input').val('');
})