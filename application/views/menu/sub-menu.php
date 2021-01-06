<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="row">
        <div class="col-lg">
            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger"><?= validation_errors(); ?></div>
            <?php endif; ?>

            <?= $this->session->flashdata('message'); ?>

            <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubmenuModal">Add Submenu Item</a>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Menu</th>
                        <th scope="col">URL</th>
                        <th scope="col">Icon</th>
                        <th scope="col">Active</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($subMenu as $subMenuItem) : ?>
                        <tr>
                            <th scope="row"><?= $i++ ?></th>
                            <td><?= $subMenuItem['title'] ?></td>
                            <td><?= $subMenuItem['menu'] ?></td>
                            <td><?= $subMenuItem['url'] ?></td>
                            <td><?= $subMenuItem['icon'] ?></td>
                            <td><?= $subMenuItem['is_active'] ?></td>
                            <td>
                                <?= $subMenuItem['title'] != 'Menu Management' && $subMenuItem['title'] != 'Sub Menu Management'
                                    ? '<a href="#" class="badge badge-pill badge-primary" data-toggle="modal" data-target="#editModal-' . $subMenuItem['id'] . '">Edit</a>
                                <a href="' . base_url('menu/deletesubmenu/') . $subMenuItem['id'] . '" class="badge badge-pill badge-warning">Delete</a>' : '' ?>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="editModal-<?= $subMenuItem['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel-<?= $subMenuItem['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel-<?= $subMenuItem['id']; ?>">Edit Sub Menu</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?= form_open(base_url('menu/editsubmenu/') . $subMenuItem['id']); ?>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="title" name="title" placeholder="Submenu title" value="<?= $subMenuItem['title'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" name="menu_id" id="menu_id">
                                                <?php foreach ($menu as $menuItem) : ?>
                                                    <option value="<?= $menuItem['id'] ?>" <?= $menuItem['menu'] == $subMenuItem['menu'] ? 'selected' : '' ?>>
                                                        <?= $menuItem['menu']; ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="url" name="url" placeholder="Submenu URL" value="<?= $subMenuItem['url'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="icon" name="icon" placeholder="Submenu Icon" value="<?= $subMenuItem['icon'] ?>">
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?= $subMenuItem['is_active'] == 1 ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="is_active">
                                                Active?
                                            </label>
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
<div class="modal fade" id="newSubmenuModal" tabindex="-1" aria-labelledby="newSubmenuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSubmenuModalLabel">Add New Submenu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/submenu') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="title" name="title" placeholder="Submenu title">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="menu_id" id="menu_id">
                            <option value="">Select Menu</option>
                            <?php foreach ($menu as $menuItem) : ?>
                                <option value="<?= $menuItem['id']; ?>"><?= $menuItem['menu']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="url" name="url" placeholder="Submenu URL">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="Submenu Icon">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" checked>
                        <label class="form-check-label" for="is_active">
                            Active?
                        </label>
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