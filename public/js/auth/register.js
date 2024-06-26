$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$(document).on("submit", "#register-submit", function (e) {
    event.preventDefault();
    var formData = new FormData(this);
    toggleLoader("block");
    $.ajax({
        type: "POST",
        url: "/register",
        data: formData,
        dataType: "json",
        processData: false,
        contentType: false,
        success: function (data) {
            window.location.href = "admin";
            toggleLoader("none");
            setTimeout(() => {
                toastr.success(data.message);
            }, 1000);
        },
        error: function (err) {
            $(".error").remove();
            $(".alert-danger").remove();
            toggleLoader("none");
            if (err.status == 422) {
                var errors = JSON.parse(err.responseText);
                $.each(errors.errors, function (i, error) {


                    var el = $(document).find('[name="' + i + '"]');

                    if (i == 'location_id')
                        var el = $('#location_id').next();

                    if (i == 'timezone')
                        var el = $('#timezone').next();

                    el.after(
                        $(
                            '<span class="error text-danger">' +
                            error +
                            "</span>"
                        )
                    );
                });
            }
            /* if credentials does not match */
            if (err.status == 403) {
                var error = JSON.parse(err.responseText);
                $("#login-text").append(
                    `<div class="alert alert-danger alert-block mt-2">
              <button type="button" class="close" data-dismiss="alert">×</button>
              ${error.message}
            </div>`
                );
            }
        },
    });
});
