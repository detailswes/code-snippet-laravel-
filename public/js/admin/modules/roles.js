var clicked = false;
$(document).on('click', '#checkAll', function() {
   $(".form-check-input").prop("checked", !clicked);
   clicked = !clicked;
   this.innerHTML = clicked ? 'Deselect' : 'Select';
})

/* CREATE AND UPDATE ROLES AND PERMISSIONS */
$(document).on("click", ".action.editRole, #create_role", function() {
   var roleId = $(this).data("id");
   $.ajax({
      type: "POST",
      url: base_url + '/open/roles/modal',
      dataType: 'json',
      data: {
         id: roleId,
         view: 'admin.roles.create-edit-role'
      },
      success: function(data) {
         $('body').append(data.html);
         $('#role-modal').modal('show');
         $("#role-modal").on('hide.bs.modal', function() {
            $("#role-modal").remove();
         });
         $('#createUserRole').submit(function(e) {
            var id = roleId ?? '';
            var name = $('#name').val();
            var permissions = [];
            $.each($("input[name='permissions']:checked"), function() {
               permissions.push($(this).val());
            });
            e.preventDefault();
            $.ajax({
               type: "POST",
               url: base_url + '/roles',
               data: {
                  id: id,
                  permissions: permissions,
                  name: name
               },
               success: function(data) {
                  toastr.success(data.message);
                  $("#role-modal").modal('hide');
                  $(".scroll").load(location.href + " .scroll");
                  $(".create").load(location.href + " .create");
                  $("#mainData").load(location.href + " #mainData");
               },
               error: function(err) {
                  $('.error').remove();
                  if (err.status == 422) {
                     var errors = JSON.parse(err.responseText);
                     $.each(errors.errors, function(i, error) {
                        var el = $(document).find('[name="' + i + '"]');
                        el.after($('<span class="error text-danger">' + error + '</span>'));
                     });
                  }
               }
            });
         });
      }
   });
});

/* DELETE ROLES AND PERMISSIONS */
$(document).on("click", ".action2.deleteRole", function() {
   var roleId = $(this).data("id");
   $.ajax({
      type: "POST",
      type: "POST",
      url: base_url + '/confirm-modal',
      dataType: 'json',
      data: {
          id: roleId,
          body_text: 'Are you sure you want to delete this Role?',
          left_button_id: 'destroy-confirm',
          left_button_class: 'btn-primary',
          left_button_name: 'Yes'
      },
      success: function(data) {
         $('body').append(data.html);
         $('#confirm-modal').modal('show');
         $("#confirm-modal").on('hide.bs.modal', function() {
            $("#confirm-modal").remove();
         });
         $('#destroy-confirm').click(function(e) {
            e.preventDefault();
            $.ajax({
               type: "DELETE",
               url: base_url + '/roles/' + roleId,
               contentType: false,
               cache: false,
               processData: false,
               dataType: "json",
               success: function(data) {
                  $("#mainData").load(location.href + " #mainData");
                  $('#destroy-confirm').modal('hide');
                  toastr.error(data.message);
               }, error: function(err) {
                 if (err.status == 401) {
                     toastr.error(err.responseJSON.message);
                 }
                 console.log(err)
               }
            });
         });
      }
   });
});
