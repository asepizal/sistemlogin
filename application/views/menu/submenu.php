 <!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Sub Menu Management</h1>
<div class="row">
  <div class="col-md-4">
    <?php if(validation_errors()) :?>
        <div class="alert alert-danger" role="alert">
            <?= validation_errors() ?>
        </div>    
    <?php endif ; ?>

    <?= $this->session->flashdata('notif'); ?>
  </div>
</div>

  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addnewSubmenu">
    add new sub menu
  </button>

  <table class="table col">
    <thead class="thead-light">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Submenu</th>
        <th scope="col">Menu</th>
        <th scope="col">url</th>
        <th scope="col">icon</th>
        <th scope="col" class="text-center">is_active</th>
        <th scope="col" class="text-center">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1 ?>
      <?php foreach ($submenu as $sm) : ?>
      <tr>
        <th scope="row"><?= $i ?></th>
        <td><?= $sm['title'] ?></td>
        <td><?= $sm['menu'] ?></td>
        <td><?= $sm['url'] ?></td>
        <td><?= $sm['icon'] ?></td>
        <td class="text-center"><?= $sm['is_active'] ?></td>
        <td class="text-center">
          <a class="badge badge-success">Edit</a>
          <a class="badge badge-danger" href="<?= base_url('menu/deleteMenu/').$sm['id'] ?>">Delete</a>
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
<div class="modal fade" id="addnewSubmenu" tabindex="-1" role="dialog" aria-labelledby="addnewSubmenuLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Submenu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?= form_open('menu/subMenu',['method'=>'POST']); ?>
        <div class="modal-body">
            <div class="form-group">
                <input type="text" class="form-control" id="formGroupExampleInput" name="submenu" placeholder="submenu name">
            </div>
            <div class="form-group">
                <select name="menu" id="" class="form-control">
                <?php foreach ($menu as $m) :?> 
                    <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
                <?php endforeach ; ?>
                </select>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="formGroupExampleInput" name="url" placeholder="url">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="formGroupExampleInput" name="icon" placeholder="icon">
            </div>
            <div class="form-group">
                <label for="is_active">Active ?</label>
                <input type="checkbox" id="is_active" name="is_active" aria-label="Checkbox for following text input" value="1" checked>
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