<div class="container">
  <div class="card o-hidden border-0 shadow-lg col-sm-12 col-md-8 my-5 mx-auto">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-sm-12">
          <div class="p-5">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
            </div>
            <?= form_open('auth/registration',['method'=>'POST', 'class'=>'user']); ?>
              <div class="form-group">
                <?= form_input(['class'=>'form-control form-control-user','name'=>'name','placeholder'=>'Full Name']); ?>
                <?= form_error('name','<small class="text-danger pl-3">','</small>'); ?>
              </div>
              <div class="form-group">
                <?= form_input(['class'=>'form-control form-control-user','name'=>'email','placeholder'=>'Email Address']); ?>
                <?= form_error('email','<small class="text-danger pl-3">','</small>'); ?>
              </div>
              <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <?= form_password(['class'=>'form-control form-control-user','name'=>'password1','placeholder'=>'Password']); ?>
                  <?= form_error('password1','<small class="text-danger pl-3">','</small>'); ?>
                </div>
                <div class="col-sm-6">
                  <?= form_password(['class'=>'form-control form-control-user','name'=>'password2','placeholder'=>'Repeat Password']); ?>
                  <?= form_error('password2','<small class="text-danger pl-3">','</small>'); ?>
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-user btn-block">
                Register Account
              </button>
            <?= form_close(); ?>
            <hr>
            <div class="text-center">
              <a class="small" href="<?= base_url('auth/forgotPassword'); ?>">Forgot Password?</a>
            </div>
            <div class="text-center">
              <a class="small" href="<?= base_url('auth'); ?>">Already have an account? Login!</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>