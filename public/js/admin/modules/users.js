var filters = '';
$(document).ready(function () {
    initDataTable();
});
$(document).on("click", ".action2.editData, #create_user", function () {
    var userId = $(this).data("id");
    $.ajax({
        type: "POST",
        url: base_url + '/open/user/modal',
        dataType: 'json',
        data: {
            id: userId,
            view: 'admin.users.create'
        },
        success: function (data) {
            $('body').append(data.html);
            $('#user-modal').modal('show');
            $("#user-modal").on('hide.bs.modal', function () {
                $("#user-modal").remove();
            });
            $('#create-form').submit(function (e) {
                const payload = new FormData(this);
                payload.append('id', (userId ?? ''))
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: base_url + '/users',
                    data: payload,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function (data) {
                        $('#myTable').DataTable().ajax.reload();
                        $('#user-modal').modal('hide');
                        toastr.success(data.message);
                    },
                    error: function (error) {
                        if (error.status === 422) {
                            const {
                                errors
                            } = error.responseJSON;
                            $.each(errors, function (key, value) {
                                $('.' + key + '-error').html(value);
                            });
                        }
                    }
                });
            });
        }
    });
});

$(document).on("click", ".action2.deleteData", function () {
    var userId = $(this).data("id");
    $.ajax({
        type: "POST",
        url: base_url + '/confirm-modal',
        dataType: 'json',
        data: {
            id: userId,
            body_text: 'Are you sure you want to delete this User?',
            left_button_id: 'destroy-confirm',
            left_button_class: 'btn-primary',
            left_button_name: 'Yes'
        },
        success: function (data) {
            $('body').append(data.html);
            $('#confirm-modal').modal('show');
            $("#confirm-modal").on('hide.bs.modal', function () {
                $("#confirm-modal").remove();
            });
            $('#destroy-confirm').click(function (e) {
                e.preventDefault();
                $.ajax({
                    type: "DELETE",
                    url: base_url + "/users/" + userId,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success: function (data) {
                        $('#myTable').DataTable().ajax.reload();
                        $('#destroy-confirm').modal('hide');
                        toastr.success(data.message);
                    }
                });
            });
        }
    });
});

$(document).on("click", ".action2.viewData", function () {
    var userId = $(this).data("id");
    $.ajax({
        type: "POST",
        url: base_url + '/open/user/modal',
        dataType: 'json',
        data: {
            id: userId,
            view: 'admin.users.view'
        },
        success: function (data) {
            if ($('#view-modal').is(':visible')) {
                $('#view-modal').empty().html($.parseHTML(data.html)[0].innerHTML);
            } else {
                $('body').append(data.html);
            }
            $('.active-datarow').removeClass('active-datarow');
            var deep = $('a.action2.deleteData[data-id=' + userId + ']').parents('tr').addClass('active-datarow');
            console.log(deep);
            $('#view-modal').modal('show');
            $("#view-modal").on('hide.bs.modal', function () {
                $('.active-datarow').removeClass('active-datarow');
                $("#view-modal").remove();
            });
        }
    });
});

$('#destroy-confirm').click(function (e) {
    e.preventDefault();
    $.ajax({
        type: "DELETE",
        url: base_url + "/users/" + userId,
        contentType: false,
        cache: false,
        processData: false,
        dataType: "json",
        success: function (data) {
            $('#myTable').DataTable().ajax.reload();
            $('#destroy-confirm').modal('hide');
            toastr.error(data.message);
        }
    });
});

$(document).on("change", ".custom-switch-input", function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: base_url + "/update/user/status/",
        data: {
            id: $(this).data("id"),
            status: $(this).is(":checked") ? 1 : 0
        },
        dataType: "json",
        success: function (data) {
            $('#myTable').DataTable().ajax.reload();
            toastr.success(data.message);
        }
    });
});

$("#search-filters input").keypress(function (e) {
    if (e.keyCode == 13) {
        search();
    }
});

$(document).on("click", "#search-button", function (e) {
    e.preventDefault();
    search();
});

$("#roles-dropdown").change(function (e) {
    e.preventDefault();
    search();
});

$(document).on("click", "#reset-search", function (e) {
    e.preventDefault();
    $("#search-filters :input").each(function (ele) {
        $(this).val('');
    });
    search();
});

function initDataTable() {
    var table = $('#myTable').DataTable({
        language: {
            paginate: {
                previous: "<i class='simple-icon-arrow-left'></i>",
                next: "<i class='simple-icon-arrow-right'></i>"
            },
        },
        searching: false,
        dom: 'Blfrtip',
        buttons: [{
            extend: 'excel',
            text: 'Export',
            title: '',
            className: 'btn btn-dark default  btn-lg mb-2 mb-lg-0 col-12 col-lg-auto mb-2',
            exportOptions: {
                columns: "thead th:not(.noExport)",
                header: false,
                format: {
                    body: function (data, row, column, node) {
                        if (column === 5) {
                            return $(data).find('input').is(':checked') ? 'Enabled' :
                                'Disabled';
                        }
                        return data;
                    }
                }
            }
        },],
        initComplete: function () {
            var btns = $('.dt-button');
            btns.addClass('btn btn-success btn-sm');
            btns.removeClass('dt-button');
        },
        processing: true,
        serverSide: true,
        ajax: base_url + "/users?" + filters,
        columns: [{
            data: 'id',
            name: 'id'
        },
        {
            data: 'first_name',
            name: 'first_name'
        },
        {
            data: 'last_name',
            name: 'last_name',

        },
        {
            data: 'email',
            name: 'email'
        },
        {
            data: 'roles',
            name: 'roles'
        },
        {
            data: 'status',
            name: 'status'
        },
        {
            data: 'created_at',
            name: 'created_at'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        },

        ],
    });
    table.on('draw.dt', function () {
        var info = table.page.info();
        table.column(0, {
            search: 'applied',
            order: 'applied',
            page: 'applied'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + info.start;
        });
    });
}

function search() {
    filters = '';
    $("#search-filters :input").each(function (index) {
        const element = $(this);
        if (element.attr('name')) {
            filters += `${index != 0 ? '&' : ''}filters[${element.attr('name')}]=${element.val()}`;
        };
    });
    $('#myTable').DataTable().destroy();
    initDataTable();
}
