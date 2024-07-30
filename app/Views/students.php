<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a35a3d4889.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</head>
<body>

<div class="row justify-content-center m-2 p-5">
  <div class="col-8">
    <div class="alert alert-primary" id="successAlert" role="alert" style="display:none;">
      Student successfully added!
    </div>
        
    <table class="table table-striped" id="studentsPg">
      <thead class="thead-dark">
        <div class="row bg-dark py-2">
          <div class="col">
            <h2 class="text-white">Students Record</h2>
          </div>
          <div class="col-auto">
            <button class="btn float-end btn-info text-white mb-1" id="addStudentBtn" data-bs-toggle="modal" data-bs-target="#studentModal">
              <i class="fa-solid fa-plus mx-1" style="color: #95ff98;"></i>Add Student
            </button>
          </div>
        </div>
        <tr>
          <th scope="col">Student ID</th>
          <th scope="col">Name</th>
          <th scope="col">Number</th>
          <th scope="col">Age</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody id="studentsTable">
        <!-- Student records will be populated here -->
      </tbody>
    </table>
    
    <div class="d-flex justify-content-between">
      <button class="btn btn-primary" id="prevPageBtn"><i class="fa-solid fa-caret-left" style="color: #74C0FC;"></i></button>
      <span id="pageInfo" class="align-self-center"></span>
      <button class="btn btn-primary" id="nextPageBtn"><i class="fa-solid fa-caret-right" style="color: #74C0FC;"></i></button>
    </div>
  </div>
</div>

<!-- Student Modal -->
<div class="modal fade" id="studentModal" tabindex="-1" role="dialog" aria-labelledby="studentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="studentModalLabel">Add Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="studentForm">
          <input type="hidden" id="studentModalAction" value="add">
          <input type="hidden" id="editStudentId">
          <div class="mb-3">
            <label for="studentId" class="form-label">Student ID</label>
            <input type="text" class="form-control" id="studentId" required>
          </div>
          <div class="mb-3">
            <label for="studentName" class="form-label">Name</label>
            <input type="text" class="form-control" id="studentName" required>
          </div>
          <div class="mb-3">
            <label for="studentPhone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="studentPhone" required>
          </div>
          <div class="mb-3">
            <label for="studentAge" class="form-label">Age</label>
            <input type="number" class="form-control" id="studentAge" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveStudentBtn">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  var currentPage = 1;

  // Load student data when the page loads
  loadStudentData(currentPage);

  // Handle add student button click
  $('#addStudentBtn').on('click', function() {
    $('#studentModalAction').val('add');
    $('#studentModalLabel').text('Add Student');
    $('#studentForm')[0].reset();
  });

  // Save student data
  $('#saveStudentBtn').on('click', function() {
    var action = $('#studentModalAction').val();
    var studentId = $('#studentId').val();
    var studentName = $('#studentName').val();
    var studentPhone = $('#studentPhone').val();
    var studentAge = $('#studentAge').val();
    var editStudentId = $('#editStudentId').val();

    if (studentName && studentPhone && studentAge) {
      var formData = {
        student_id: studentId,
        name: studentName,
        phone: studentPhone,
        age: studentAge
      };

      var url = action === 'add' ? '<?= base_url('ajax/add');?>' : '<?= base_url('ajax/update?id=');?>' + editStudentId;
      var type = action === 'add' ? 'POST' : 'PUT';

      $.ajax({
        url: url,
        type: type,
        contentType: 'application/json',
        data: JSON.stringify(formData),
        success: function(response) {
          if (response.status == 'success') {
            $('#successAlert')
              .removeClass('alert-danger')
              .addClass('alert-primary')
              .text(response.message).show();
            setTimeout(function() {
              $('#successAlert').fadeOut('slow');
            }, 2000);
            closeModal('#studentModal');
            loadStudentData(currentPage);
          }
        },
        error: function(error) {
          alert('Error saving student data');
        }
      });
    } else {
      alert('Please fill out all fields');
    }
  });

  // Handle delete operation
  $(document).on('click', '.delete-student', function() {
    var studentId = $(this).data('id');
    if (confirm('Are you sure you want to delete this student?')) {
      $.ajax({
        url: '<?= base_url('ajax/delete?id=');?>' + studentId,
        type: 'DELETE',
        success: function(response) {
          if (response.status == 'success') {
            $('#successAlert')
              .removeClass('alert-primary')
              .addClass('alert-danger')
              .text(response.message).show();
            setTimeout(function() {
              $('#successAlert').fadeOut('slow');
            }, 2000);
            loadStudentData(currentPage);
          } else {
            alert('Error deleting student');
          }
        },
        error: function(error) {
          alert('Error deleting student');
        }
      });
    }
  });

  // Open edit student modal and populate it with student data
  $(document).on('click', '.edit-student', function() {
    var studentId = $(this).data('student_id');
    var id = $(this).data('id');
    var studentName = $(this).data('name');
    var studentPhone = $(this).data('phone');
    var studentAge = $(this).data('age');

    $('#studentModalAction').val('edit');
    $('#studentModalLabel').text('Edit Student');
    $('#editStudentId').val(id);
    $('#studentId').val(studentId);
    $('#studentName').val(studentName);
    $('#studentPhone').val(studentPhone);
    $('#studentAge').val(studentAge);

    $('#studentModal').modal('show');
  });

  // Handle pagination
  $('#prevPageBtn').on('click', function() {
    if (currentPage > 1) {
      currentPage--;
      loadStudentData(currentPage);
    }
  });

  $('#nextPageBtn').on('click', function() {
    currentPage++;
    loadStudentData(currentPage);
  });
});

// Function to load student data
function loadStudentData(page) {
  $.ajax({
    url: '<?= base_url('get-students');?>',
    type: 'GET',
    data: { page: page },
    success: function(response) {
      var students = response.students;
      $('#studentsTable').empty(); // Clear existing rows
      $.each(students, function(index, student) {
        appendStudentRow(student);
      });

      // Update pagination info
      $('#pageInfo').text('Page ' + response.currentPage + ' of ' + response.totalPages);

      // Enable/disable pagination buttons
      $('#prevPageBtn').prop('disabled', response.currentPage === 1);
      $('#nextPageBtn').prop('disabled', response.currentPage === response.totalPages);
    },
    error: function(error) {
      alert('Error fetching student data');
    }
  });
}

// Function to append a student row to the table
function appendStudentRow(student) {
  var studentRow = '<tr>' +
    '<td>' + student.student_id + '</td>' +
    '<td>' + student.name + '</td>' +
    '<td>' + student.phone + '</td>' +
    '<td>' + student.age + '</td>' +
    '<td>' +
    '<button class="btn btn-primary text-white text-decoration-none edit-student" data-id="' + student.id + '" data-student_id="' + student.student_id + '" data-name="' + student.name + '" data-phone="' + student.phone + '" data-age="' + student.age + '">' +
    '<i class="fa-solid fa-pen-to-square"></i></button>' +
    '<button class="btn btn-danger text-white text-decoration-none mx-2 delete-student" data-id="' + student.id + '">' +
    '<i class="fa-solid fa-trash"></i> </button>' +
    '</td>' +
    '</tr>';
  $('#studentsTable').append(studentRow);
}

// Custom function to close a modal and remove the backdrop
function closeModal(modalId) {
  $(modalId).modal('hide');
  $('.modal-backdrop').remove(); // Remove the modal backdrop
}
</script>

</body>
</html>
