<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <?= $this->session->flashdata('message'); ?>
            <?= form_open('user/changepassword'); ?>
            <div class="form-group">
                <label for="currentPassword">Current Password</label>
                <input type="password" class="form-control" id="currentPassword" name="currentPassword">
                <?= form_error('currentPassword', '<small class="text-danger">', '</small>'); ?>
            </div>
            <div class="form-group">
                <label for="newPassword">New Password</label>
                <input type="password" class="form-control" id="newPassword" name="newPassword">
                <?= form_error('newPassword', '<small class="text-danger">', '</small>'); ?>
            </div>
            <div class="form-group">
                <label for="retypeNewPassword">Retype Password</label>
                <input type="password" class="form-control" id="retypeNewPassword" name="retypeNewPassword">
                <?= form_error('retypeNewPassword', '<small class="text-danger">', '</small>'); ?>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->