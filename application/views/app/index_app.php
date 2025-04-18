<div class="card">
    <div class="card-header">
        <a href="#modal-app" data-toggle="modal" class="btn btn-dark" id="btn-add">Add App</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-sm responsive dataTable no-wrap" id="tbl-app" width="100%">
            <thead>
                <tr>
                    <th>ID App</th>
                    <th>App Name</th>
                    <th>Is<br>Active</th>
                    <th>Cipher<br>Name</th>
                    <th>Cipher<br>Mode</th>
                    <th>Cipher Key</th>
                    <th>URL Authentication</th>
                    <th>Image</th>
                    <th>--</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modal-app">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ADD APP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label for="app_name" class="col-sm-3 text-left control-label col-form-label">App Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="app_name" value="" placeholder="Nama Sistem">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="url" class="col-sm-3 text-left control-label col-form-label">URL Auth</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="url" value=""
                            placeholder="http://localhost/App/Auth/verify">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="app_image" class="col-sm-3 text-left control-label col-form-label">Image
                        App</label>
                    <div class="col-sm-9">
                        <img class="img-preview img-fluid" id="img-preview">
                        <input type="file" class="form-control imgInput" id="app_image" onchange="previewImage()"
                            required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cipher_name" class="col-sm-3 text-left control-label col-form-label">
                        Chiper Name</label>
                    <div class="col-sm-9">
                        <select id="cipher_name" class="form-control ">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cipher_mode" class="col-sm-3 text-left control-label col-form-label">
                        Cipher Mode</label>
                    <div class="col-sm-9">
                        <select id="cipher_mode" class="form-control ">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cipher_key" class="col-sm-3 text-left control-label col-form-label">
                        Cipher Key</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="cipher_key" value="">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-primary" id="btn-save">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const base_url = window.location.origin + "/Satu/App/";
let proses = null;
let id_app = null;
let tbl_app = null;

$(document).ready(function() {
    tbl_app = $("#tbl-app").DataTable({
        autoWidth: true,
        responsive: true,
        "columnDefs": [{
            "orderable": false,
            "targets": [8]
        }],
        serverSide: true,
        processing: true,
        ajax: {
            url: base_url + "show",
            type: "POST",
        },
        columns: [{
                data: 'id_app'
            },
            {
                data: 'app_name',
                className: 'text-nowrap',
            },
            {
                data: null,
                className: 'text-center',
                render: function(data, type, row, meta) {
                    let is_active = row.is_active == 1 ? 0 : 1;
                    let is_checked = row.is_active == 1 ? 'checked' : '';
                    return `<label class="customcheckbox">
                            <input class="listCheckbox" type="checkbox" value="${is_active}" data-id='${row.id_app}' ${is_checked}>
                        </label>`;
                }
            },
            {
                data: 'cipher_name',
                className: 'text-nowrap',
            },
            {
                data: 'cipher_mode'
            },
            {
                data: 'cipher_key',
                className: 'text-nowrap',
            },
            {
                data: 'url',
                className: 'text-nowrap',
            },
            {
                data: 'app_image',
                className: 'text-nowrap',
            },
            {
                data: 'id_app',
                className: 'text-nowrap',
                render: function(data, type, row, meta) {
                    return `
                         <a href="#modal-app" data-toggle="modal" class="btn btn-info btn-sm btn-edit"
                            data-id="${data}">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="btn btn-danger btn-sm btn-delete" data-id="${data}">
                            <i class="fas fa-trash"></i>
                        </a>`;
                }
            },
        ],
    });
});

$(document).on("click", ".listCheckbox", function() {
    $.ajax({
        url: base_url + "is_active",
        type: "post",
        data: {
            id_app: $(this).data("id"),
            show_app: $(this).val(),
        },
        success: function(res) {
            // if(res.status==1){
            toastr.success(res.message);
            // }
        },
    });
});

$(document).on("change", "#cipher_name", function() {
    loadChiperMode($(this).val());
});

$(document).on("click", "#btn-add", function() {
    proses = "insert";
    $("#modal-app input").val(null);
    loadCipher();
});

$(document).on("click", ".btn-edit", function() {
    proses = "update";
    $("#modal-app input").val(null);
    id_app = $(this).data('id');
    loadCipher();

    $.ajax({
        url: base_url + 'get',
        type: 'POST',
        data: {
            id_app: id_app
        },
        dataType: 'json',
        success: function(res) {
            if (res.status == 1) {
                $('#app_name').val(res.data.app_name);
                $('#url').val(res.data.url);
                $('#cipher_name').val(res.data.cipher_name);
                $('#cipher_mode').val(res.data.cipher_mode);
                $('#cipher_key').val(res.data.cipher_key);
            }
        }
    });
});

$(document).on("click", "#btn-save", function() {
    var values = new FormData();
    values.append('id_app', id_app);
    values.append('app_name', $('#app_name').val());
    values.append('url', $('#url').val());
    values.append('cipher_name', $('#cipher_name').val());
    values.append('cipher_mode', $('#cipher_mode').val());
    values.append('cipher_key', $('#cipher_key').val());
    values.append('app_image', $('input[type=file]')[0].files[0]);

    $.ajax({
        url: base_url + proses,
        type: "POST",
        contentType: false,
        processData: false,
        data: values,
        dataType: "json",
        success: function(res) {
            if (res.status == 1) {
                toastr.success(res.message);
                tbl_app.ajax.reload(null, false);
                $('#modal-app').modal('hide');
            } else {
                toastr.error(res.message);
            }
        },
    });
});

$(document).on("click", ".btn-delete", function() {
    if (confirm("Are you sure you will delete ?")) {
        $.ajax({
            url: base_url + "delete",
            type: "POST",
            data: {
                id_app: $(this).data('id'),
            },
            dataType: "json",
            success: function(res) {
                if (res.status == 1) {
                    tbl_app.ajax.reload(null, false);
                    toastr.success(res.message);
                } else {
                    toastr.error(res.message);
                }
            },
        });
    }
});

function previewImage() {
    const image = document.querySelector(".imgInput");
    const imgPreview = document.querySelector(".img-preview");
    imgPreview.style.display = "block";
    const oFReader = new FileReader();
    oFReader.readAsDataURL(image.files[0]);
    oFReader.onload = function(oFREvent) {
        imgPreview.src = oFREvent.target.result;
    };
}

function loadCipher() {
    $.ajax({
        url: base_url + "load_cipher",
        type: "GET",
        dataType: "json",
        success: function(res) {
            let option = "";
            let value = null;
            $.each(res.data, function(i, key) {
                if (i == 0) {
                    value = key.cipher_name;
                }
                option +=
                    '<option value="' +
                    key.cipher_name +
                    '" data-mode="' +
                    key.mode +
                    '">' +
                    key.cipher_name +
                    "</option>";
            });
            $(document).find("#cipher_name").html(option);
            loadChiperMode(value);
        },
    });
}

function loadChiperMode(cipher_name) {
    $.ajax({
        url: base_url + "load_cipher_mode",
        type: "POST",
        data: {
            name: cipher_name,
        },
        dataType: "json",
        success: function(res) {
            let option = "";
            $.each(res.data, function(i, key) {
                option += '<option value="' + key + '">' + key + "</option>";
            });
            $(document).find("#cipher_mode").html(option);
        },
    });
}
</script>