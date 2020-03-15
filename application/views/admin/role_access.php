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

    <h5>Role : <?= $role['role'] ?></h5>

  <table class="table col-md-4">
    <thead class="thead-light">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Menu</th>
        <th scope="col" class="text-center">Access</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1 ?>
      <?php foreach ($menu as $m) : ?>
      <tr>
        <th scope="row"><?= $i ?></th>
        <td><?= $m['menu'] ?></td>
        <td class="text-center">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" <?= check_access($role['id'],$m['id']) ?> data-role="<?= $role['id'] ?>" data-menu="<?= $m['id'] ?>">
            </div>
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

