<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <?= form_error('menuName', '<div class="alert alert-danger">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>

            <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMenuModal">Add Menu Item</a>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($menuList as $menu) : ?>
                        <tr>
                            <th scope="row"><?= $i++ ?></th>
                            <td><?= $menu['menu'] ?></td>
                            <td>
                                <?= $menu['menu'] != 'Admin' && $menu['menu'] != 'Menu'
                                    ? '<a href="#" class="badge badge-pill badge-primary" data-toggle="modal" data-target="#editModal-' . $menu['id'] . '">Edit</a>
                                    <a href="' . base_url('menu/deletemenu/') . $menu['id'] . '" class="badge badge-pill badge-warning">Delete</a>' : '' ?>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="editModal-<?= $menu['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel-<?= $menu['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel-<?= $menu['id']; ?>">Edit Menu</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?= form_open(base_url('menu/editmenu/') . $menu['id']); ?>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="menuName" name="menuName" placeholder="Menu Name" value="<?= $menu['menu'] ?>">
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
<div class="modal fade" id="newMenuModal" tabindex="-1" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel">Add New Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="menuName" name="menuName" placeholder="Menu name">
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