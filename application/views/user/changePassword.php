 <!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Change Password</h1>
<div class="row">
    <div class="col-md-6">
        <?= $this->session->flashdata('notif'); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
    <form action="<?= base_url('user/changePassword') ?>" method="post">
    <div class="form-group">
        <label for="currentPassword">Current Password</label>
        <input type="password" class="form-control form-control-user" name="currentPassword" id="currentPassword">
        <?= form_error('currentPassword','<small class="text-danger pl-3">','</small>'); ?>
    </div>
    <div class="form-group">
        <label for="newPassword">New Password</label>
        <input type="password" class="form-control form-control-user" name="newPassword" id="newPassword">
        <?= form_error('newPassword','<small class="text-danger pl-3">','</small>'); ?>
    </div>
    <div class="form-group">
        <label for="confPassword">Repeat Password</label>
        <input type="password" class="form-control form-control-user" name="confPassword" id="confPassword">
        <?= form_error('confPassword','<small class="text-danger pl-3">','</small>'); ?>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    </form>
    </div>
</div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
     