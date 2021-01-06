<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <?= $this->session->flashdata('message'); ?>
            <h4>Role: <?= $role['role'] ?></h4>
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
                    foreach ($menuListNonAdmin as $menu) : ?>
                        <tr>
                            <th scope="row"><?= $i++ ?></th>
                            <td><?= $menu['menu'] ?></td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input role-check-input" type="checkbox" <?= checkAccess($role['id'], $menu['id']); ?> data-role="<?= $role['id']; ?>" data-menu="<?= $menu['id']; ?>">
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->