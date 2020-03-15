 <!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Menu Management</h1>
<div class="row">
  <div class="col-md-4">
    <?= form_error('menu','<div class="alert alert-danger" role="alert">','</div>') ?>

    <?= $this->session->flashdata('notif'); ?>
  </div>
</div>

  <!-- Button trigger modal -->
  <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addNewRole">
    add new Role
  </button>

  <table class="table col-md-4">
    <thead class="thead-light">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Role</th>
        <th scope="col" class="text-center">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1 ?>
      <?php foreach ($role as $r) : ?>
      <tr>
        <th scope="row"><?= $i ?></th>
        <td><?= $r['role'] ?></td>
        <td class="text-center">
          <a class="badge badge-info" href="<?= base_url('admin/roleAccess/').$r['id'] ?>">Access</a>
          <a class="badge badge-success" href="">Edit</a>
          <a class="badge badge-danger" href="<?= base_url('admin/deleteRole/').$r['id'] ?>">Delete</a>
        </td>
      </tr>
      <?php $i++ ?>
      <?php endforeach ; ?>
    </tbody>
  </table>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->




<!-- Modal -->
<div class="modal fade" id="addNewRole" tabindex="-1" role="dialog" aria-labelledby="addNewRoleLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open('admin/role',['method'=>'POST']); ?>
        <div class="modal-body">
            <div class="form-group">
                <input type="text" class="form-control" id="formGroupExampleInput" name="role" placeholder="role name">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add</button>
        </div>
      <?= form_close() ?> 
    </div>
  </div>
</div>