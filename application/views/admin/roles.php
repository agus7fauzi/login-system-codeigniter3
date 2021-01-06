<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <?= form_error('roleName', '<div class="alert alert-danger">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>

            <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newRoleModal">Add Role Item</a>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($role as $roleItem) : ?>
                        <tr>
                            <th scope="row"><?= $i++ ?></th>
                            <td><?= $roleItem['role'] ?></td>
                            <td>
                                <a href="<?= base_url('admin/rolesaccess/') . $roleItem['id']; ?>" class="badge badge-pill badge-primary">Access</a>
                                <?= $roleItem['role'] != 'Administrator'
                                    ? '<a href="' . base_url('admin/deleterole/') . $roleItem['id'] . '" class="badge badge-pill badge-warning" data-toggle="modal" data-target="#editModal-' . $roleItem['id'] . '">Edit</a>
                                    <a href="' . base_url('admin/deleterole/') . $roleItem['id'] . '" class=" badge badge-pill badge-danger">Delete</a>' : '' ?>

                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="editModal-<?= $roleItem['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel-<?= $roleItem['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel-<?= $roleItem['id']; ?>">Edit Role</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?= form_open(base_url('admin/editrole/') . $roleItem['id']); ?>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="roleName" name="roleName" placeholder="Role Name" value="<?= $roleItem['role']; ?>">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal -->
<div class="modal fade" id="newRoleModal" tabindex="-1" aria-labelledby="newRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleModalLabel">Add New Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/roles') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="roleName" name="roleName" placeholder="Role name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>