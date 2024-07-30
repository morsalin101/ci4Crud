<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>MORSALIN | CI4</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
</head>
<body>
<!-- Section: Design Block -->
<section class="">
  <div class="px-4 py-5 px-md-5 text-center text-lg-start" style="background-color: hsl(0, 0%, 96%)">
    <div class="container">
      <div class="row gx-lg-5 align-items-center">
        <div class="col-lg-6 mb-5 mb-lg-0">
          <h1 class="my-5 display-3 fw-bold ls-tight">
            This is a CRUD application <br />
            <span class="text-primary">individual CRUD</span>
          </h1>
          <p style="color: hsl(217, 10%, 50.8%)">
            First  you should create an account to access the CRUD application.
            Then you can login to the application and perform CRUD operations.
            It will be individual CRUD operations.
          </p>
        </div>
        <div class="col-lg-6 mb-5 mb-lg-0">
          <div class="card">
         
            <div class="card-body py-5 px-md-5">
            <div class="alert alert-success d-none" role="alert" id="successAlert">
                Account created successfully
              </div>

            <h1 class="card-title ">Create Your Account</h1>
              <form id="signupForm">
                <div data-mdb-input-init class="form-outline mb-4">
                  <label class="form-label" for="name">Name</label>
                  <input type="text" id="name" class="form-control" />
                  <span class="text-danger" id="nameError"></span>
                </div>
                <div data-mdb-input-init class="form-outline mb-4">
                  <label class="form-label" for="email">Email address</label>
                  <input type="email" id="email" class="form-control" />
                  <span class="text-danger" id="emailError"></span>
                </div>
                <div data-mdb-input-init class="form-outline mb-4">
                  <label class="form-label" for="password">Password</label>
                  <input type="password" id="password" class="form-control" />
                  <span class="text-danger" id="passwordError"></span>
                </div>
                <div data-mdb-input-init class="form-outline mb-4">
                  <label class="form-label" for="confirmPassword">Confirm Password</label>
                  <input type="password" id="confirmPassword" class="form-control" />
                  <span class="text-danger" id="confirmPasswordError"></span>
                </div>
                
                <div class="row">
              
                <button type="submit" data-mdb-button-init data-mdb-ripple-init class=" btn btn-primary btn-block mb-3">
                  Sign up
                </button>
                <p>Already have an account? <a  class="text-decoration-none" href="<?=base_url('login')?>">Login</a></p>  
          
                                        
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
  $('#signupForm').on('submit', function(event) {
    event.preventDefault();
    
    // Clear previous error messages
    $('#nameError').text('');
    $('#emailError').text('');
    $('#passwordError').text('');
    $('#confirmPasswordError').text('');
    $('#successAlert').addClass('d-none');

    // Get form data
    const formData = {
      name: $('#name').val(),
      email: $('#email').val(),
      password: $('#password').val(),
      confirmPassword: $('#confirmPassword').val()
    };

    // Basic validation
    let valid = true;
    if (!formData.name) {
      $('#nameError').text('Name is required');
      valid = false;
    }
    if (!formData.email) {
      $('#emailError').text('Email is required');
      valid = false;
    }
    if (!formData.password) {
      $('#passwordError').text('Password is required');
      valid = false;
    }
    if (!formData.confirmPassword) {
      $('#confirmPasswordError').text('Confirm Password is required');
      valid = false;
    }
    if (formData.password !== formData.confirmPassword) {
      $('#confirmPasswordError').text('Passwords do not match');
      valid = false;
    }

    if (valid) {
      $.ajax({
        url: "<?= base_url('signup');?>",
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(formData),
        success: function(response) {
          if (response.status === 'success') {
            $('#successAlert').removeClass('d-none');
          } else {
            alert('Signup failed: ' + response.message);
          }
        },
        error: function(xhr, status, error) {
          alert('Signup failed: ' + xhr.responseText);
        }
      });
    }
  });
});

</script>
</body>
</html>
