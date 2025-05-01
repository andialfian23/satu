<div class="card">
    <div class="card-header">
        <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#modal-level" id="btn-add">Create Level</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-sm responsive dataTable no-wrap" id="tbl-level" width="100%">
                <thead>
                    <tr>
                        <th>ID Level</th>
                        <th>ID APP</th>
                        <th>App Name</th>
                        <th>App Level</th>
                        <th>Level Name</th>
                        <th>--</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#modal-level" id="btn-add-user">Add User</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-sm responsive dataTable no-wrap" id="tbl-user" width="100%">
                <thead>
                    <tr>
                        <th>ID User</th>
                        <th>Username</th>
                        <th>Title</th>
                        <th>ID Level</th>
                        <th>App Level</th>
                        <th>Level Name</th>
                        <th>--</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-level">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ADD LEVEL APP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label for="id_level" class="col-sm-3 text-left control-label col-form-label">ID Level</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="id_level" id="id_level" value="">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id_app" class="col-sm-3 text-left control-label col-form-label">App</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="id_app">
                            <?php foreach($apps->result() as $key): ?>
                            <option value="<?= $key->id_app ?>"><?= $key->app_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="app_level" class="col-sm-3 text-left control-label col-form-label">App Level</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="app_level" name="app_level" value="">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="level_name" class="col-sm-3 text-left control-label col-form-label">Level
                        Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="level_name" name="level_name" value="">
                    </div>
                </div>
                <div class="form-group row">
                    <button class="btn btn-block btn-primary" type="submit" id="btn-save">SIMPAN</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const base_url = window.location.origin + "/Satu/Level/";
let proses = null;
let id_level = null;
let id_app = null;
let tbl_level = null;
let tbl_user = null;

$(document).ready(function() {
    tbl_level = $("#tbl-level").DataTable({
        autoWidth: true,
        responsive: true,
        columnDefs: [{
            orderable: false,
            targets: [5]
        }],
        serverSide: true,
        processing: true,
        ajax: {
            url: base_url + "show",
            type: "POST",
        },
        columns: [{
                data: 'id_level',
            },
            {
                data: 'id_app'
            },
            {
                data: 'app_name'
            },
            {
                data: 'app_level'
            },
            {
                data: 'level_name',
                render: function(data, type, row, meta) {
                    return `<a href="#" class="btn-detail" data-level="${row.id_level}" data-app="${row.id_app}">${data}</a>`;
                }
            },
            {
                data: 'id_level',
                render: function(data, type, row, meta) {
                    return `
                        <a href="<?= base_url() ?>ref/level?id_level=${data}" target="_blank"
                            class="btn btn-secondary btn-sm">
                            API
                        </a>
                        <a href="#modal-level" data-toggle="modal" class="btn btn-info btn-sm btn-edit"
                            data-id="${data}">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="btn btn-danger btn-sm btn-delete" data-id="${data}">
                            <i class="fa fa-trash"></i>
                        </a>
                    `;
                }
            },
        ],
    });

    tbl_user = $("#tbl-user").DataTable({
        autoWidth: true,
        responsive: true,
        columnDefs: [{
            orderable: false,
            targets: [6]
        }],
        serverSide: true,
        processing: true,
        ajax: {
            url: base_url + "user",
            type: "POST",
            data: function(d) {
                d.id_level = id_level;
                d.id_app = id_app;
            }
        },
        columns: [{
                data: 'id_user',
            },
            {
                data: 'username'
            },
            {
                data: 'title'
            },
            {
                data: 'id_level'
            },
            {
                data: 'app_level'
            },
            {
                data: 'level_name',
            },
            {
                data: 'id_level',
                className: 'text-nowrap',
                render: function(data, type, row, meta) {
                    return `<a href="#modal-level" data-toggle="modal" class="btn btn-info btn-sm btn-edit"
                            data-id="${data}">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="btn btn-danger btn-sm btn-delete" data-id="${data}">
                            <i class="fa fa-trash"></i>
                        </a>`;
                }
            },
        ],
    });
});

$(document).on("click", "#btn-add", function() {
    proses = "insert";
    $("#modal-level input").val(null);
});

$(document).on("click", ".btn-edit", function() {
    id_level = $(this).data('id');
    proses = "update";
    $("#modal-level input").val(null);
    $('#id_level').val(id_level);

    $.ajax({
        url: base_url + 'get',
        type: 'POST',
        data: {
            id_level: id_level
        },
        dataType: 'json',
        success: function(res) {
            if (res.status == 1) {
                $('#img-preview').removeAttr('src');
                $('#img-preview').attr('src', window.location.origin + '/Satu/images/app_image/' +
                    res.data.images);
                $('#id_app').val(res.data.id_app);
                $('#app_level').val(res.data.app_level);
                $('#level_name').val(res.data.level_name);
            }
        }
    });
});

$(document).on("click", "#btn-save", function() {
    var values = new FormData();
    values.append('id_level', $('#id_level').val());
    values.append('id_app', $('#id_app').val());
    values.append('app_level', $('#app_level').val());
    values.append('level_name', $('#level_name').val());

    $.ajax({
        url: base_url + proses,
        type: "POST",
        contentType: false,
        processData: false,
        data: values,
        dataType: "json",
        success: function(res) {
            if (res.status == 1) {
                tbl_level.ajax.reload(null, false);
                toastr.success(res.message);
                $('#modal-level').modal('hide');
            } else {
                toastr.error(res.message);
            }
        },
    });
});

$(document).on("click", ".btn-delete", function() {
    if (confirm("Are you sure you will deleted data?")) {
        $.ajax({
            url: base_url + "delete",
            type: "POST",
            data: {
                id_level: $(this).data('id'),
            },
            dataType: "json",
            success: function(res) {
                if (res.status == 1) {
                    tbl_level.ajax.reload(null, false);
                    toastr.success(res.message);
                } else {
                    toastr.error(res.message);
                }
            },
        });
    }
});

$(document).on('click', ".btn-detail", function() {
    id_level = $(this).data('level');
    id_app = $(this).data('app');
    tbl_user.ajax.reload(null, false);
});
</script>