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

<section class="vh-100" style="background-color: #eee;">
  <div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-12 col-xl-11">
        <div class="card text-black" style="border-radius: 25px;">
          <div class="card-body p-md-5">
            <div class="row justify-content-center">
              <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
              <div class="alert alert-success d-none" role="alert" id="successAlert">
                Login successful!
              </div>
              <div class="alert alert-danger d-none" role="alert" id="errorAlert">
                Login failed!
              </div>

                <h1 class="text-start mb-5 mx-1 mx-md-4 mt-4">Login</h1>

                <form class="mx-1 mx-md-4" >

                     <label class="form-label">Your Email</label>
                      <input type="email" name="email" id="form3Example3c" class="form-control" placeholder="example@gmail.com" />
        
                    <label class="form-label" for="form3Example4c">Password</label>
                      <input type="password" name="pass" id="form3Example4c" class="form-control" placeholder="********" />
                      
                   <div class="d-flex justify-content-start mt-4 mb-3 mb-lg-4">
                    
                    <button type="submit" class="btn btn-success btn-block btn-sm px-4">Login</button>
                  
                    <p class="mt-2 mx-2 ">Doesn't have account?<a class=" text-decoration-none text-primary mx-2" href="<?= base_url('/signup');?>">Signup</a></p>
                                        
                  </div>

                </form>

              </div>
              <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                <img src="<?= base_url('/public/assets/pic/signup.png');?>" 
                  class="img-fluid" alt="Sample image">

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>





  

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"  crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
  $('form').on('submit', function(event) {
    event.preventDefault();

    // Clear previous messages
    $('#successAlert').addClass('d-none');
    $('#errorAlert').addClass('d-none');

    // Get form data
    const formData = {
      email: $('input[name="email"]').val(),
      pass: $('input[name="pass"]').val(),
    };

    // Basic validation
    if (!formData.email || !formData.pass) {
      $('#errorAlert').text('Both fields are required').removeClass('d-none');
      return;
    }

    // AJAX request
    $.ajax({
      url: "<?= base_url('/login');?>",
      method: 'POST',
      contentType: 'application/json',
      data: JSON.stringify(formData),
      success: function(response) {
        if (response.status === 'success') {
          $('#successAlert').removeClass('d-none');
            // Redirect or further actions on success
            setTimeout(function() {
            window.location.href = "<?= base_url('/students');?>";
            }, 2000);
        } else {
          $('#errorAlert').text(response.message || 'Login failed!').removeClass('d-none');
        }
      },
      error: function(xhr, status, error) {
        $('#errorAlert').text(xhr.responseText || 'Login failed!').removeClass('d-none');
      }
    });
  });
});





</script>
</body>
</html>