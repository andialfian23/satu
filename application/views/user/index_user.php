<div class="card">
    <div class="card-header">
        <a href="#modal-user" data-toggle="modal" class="btn btn-dark">Add User</a>
    </div>
    <div class="card-body">
        <table id="tbl-users" class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>--</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                    foreach($users->result() as $key){
                ?>

                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $key->title ?></td>
                    <td><?= $key->username ?></td>
                    <td><?= $key->password ?></td>
                    <td>--</td>
                </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modal-user">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ADD USER</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label for="name" class="col-sm-3 text-left control-label col-form-label">Title</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="name" value="" placeholder="Name">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="username" class="col-sm-3 text-left control-label col-form-label">Username</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="username" value="" placeholder="Username">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-sm-3 text-left control-label col-form-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="password" value="" placeholder="Password">
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