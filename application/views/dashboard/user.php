 <!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">My Profile</h1>

<div class="card" style="width: 300px">
  <img src="<?= base_url().'assets/img/profile/'.$user['image']; ?>" alt="" class="card-img-top">
  <div class="card-body">
      <h4 class="text-capitalize"><?= $user['name']; ?></h4>
      <h6><?= $user['email']; ?></h6>
      <p>Since <?= date('d F Y',$user['date_created']); ?></p>

  </div>
</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
     