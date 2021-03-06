<div class="container">
  <!-- Outer Row -->
  <div class="row justify-content-center">
    <div class="col-sm-12 col-md-8">
      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row justify-content-center">
            <div class="col-10">
              <div class="p-5">
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                </div>
                <?= $this->session->flashdata('notif'); ?>
                <?= form_open('auth',['method'=>'POST', 'class'=>'user']); ?>
                  <div class="form-group">
                    <input type="email" class="form-control form-control-user" name="email"  aria-describedby="emailHelp" placeholder="Enter Email Address...">
                    <?= form_error('email','<small class="text-danger pl-3">','</small>'); ?>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-user" name="password" placeholder="Password">
                    <?= form_error('password','<small class="text-danger pl-3">','</small>'); ?>
                  </div>
                  <button type="submit" class="btn btn-primary btn-user btn-block">
                    Login
                  </button>
                <?= form_close(); ?>  
                <hr>
                <div class="text-center">
                  <a class="small" href="<?= base_url('auth/forgotPassword'); ?>">Forgot Password?</a>
                </div>
                <div class="text-center">
                  <a class="small" href="<?= base_url('auth/registration'); ?>">Create an Account!</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

  
