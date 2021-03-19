<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.css" />

   <title>Document</title>
</head>

<body>

   <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
         <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
               <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="#">Features</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="#">Pricing</a>
            </li>
            <li class="nav-item">
               <a class="nav-link disabled" href="#">Disabled</a>
            </li>
         </ul>
      </div>
   </nav>

   <div class="container">
      <div class="row">
         <div class="col-md-12">
            <h4 class="text-center text-danger font-weight-normal my-1">CRUD Application using bootstrap, PHP-PDO, PDO-Mysql, Ajax, Database & SweetAlert</h4>
         </div>
      </div>
      <div class="row">
         <div class="col-md-6">
            <h4 class="mt-2 text-primary">All user in database</h4>
         </div>
         <div class="col-md-6">
            <button type="button" class="btn btn-primary m-1 float-right" data-toggle="modal" data-target="#addModal">Add New User</button>
            <button type="button" class="btn btn-success m-1 float-right">Export to Excel</button>
         </div>
      </div>
      <hr class="my-1">
      <div class="row">
         <div class="col-md-12">
            <div class="table-response" id="showUser">

            </div>
         </div>
      </div>
   </div>

   <!-- Add new user modal -->
   <div class="modal fade" id="addModal">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
               <h4 class="modal-title">Add New User</h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body px-4">
               <form action="" method="POST" id="form-data">
                  <div class="form-group">
                     <input type="text" name="fname" class="form-control" placeholder="first name" required>
                  </div>
                  <div class="form-group">
                     <input type="text" name="lname" class="form-control" placeholder="last name" required>
                  </div>
                  <div class="form-group">
                     <input type="email" name="email" class="form-control" placeholder="email" required>
                  </div>
                  <div class="form-group">
                     <input type="tel" name="phone" class="form-control" placeholder="phone" required>
                  </div>
                  <div class="form-group">
                     <input type="submit" name="insert" id="insert" value="Add User" class="btn btn-danger btn-block">
                  </div>
               </form>
            </div>

         </div>
      </div>
   </div>


   <!-- edit user modal -->
   <div class="modal fade" id="editModal">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
               <h4 class="modal-title">Edit User</h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body px-4">
               <form action="" method="POST" id="edit-form-data">
                  <input type="hidden" name="id" id="id">
                  <div class="form-group">
                     <input type="text" name="fname" class="form-control" id="fname" required>
                  </div>
                  <div class="form-group">
                     <input type="text" name="lname" class="form-control" id="lname" required>
                  </div>
                  <div class="form-group">
                     <input type="email" name="email" class="form-control" id="email" required>
                  </div>
                  <div class="form-group">
                     <input type="tel" name="phone" class="form-control" id="phone" required>
                  </div>
                  <div class="form-group">
                     <input type="submit" name="update" id="update" value="Update User" class="btn btn-primary btn-block">
                  </div>
               </form>
            </div>

         </div>
      </div>
   </div>


   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.24/datatables.min.js"></script>
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

   <script>
      $(function() {

         function showAllUser() {
            $txt = ''
            $.ajax({
               url: 'http://localhost:3000/pdo_ajax/action.php',
               type: "POST",
               data: {
                  action: 'view'
               },
               success: function(data) {
                  // console.log(data);
                  $('#showUser').html(data);
                  $('table').DataTable({
                     order: [0, 'desc']
                  });
               }
            })
         }
         showAllUser();

         //add user
         $("#insert").on('click', function(e) {
            if ($('#form-data')[0].checkValidity()) {
               e.preventDefault();
               $.ajax({
                  url: 'http://localhost:3000/pdo_ajax/action.php',
                  type: 'POST',
                  data: $('#form-data').serialize() + "&action=insert",
                  success: function(data) {
                     Swal.fire({
                        title: 'Insert successfully!!',
                        icon: 'success'
                     })
                     $("#addModal").modal('hide');
                     $('#form-data')[0].reset();
                     showAllUser();
                     console.log(data);
                  }
               })
            }
         })

         //Edit user
         $('body').on('click', '.editBtn', function(e) {
            e.preventDefault();
            $edit_id = $(this).attr('id');
            $.ajax({
               url: 'http://localhost:3000/pdo_ajax/action.php',
               type: 'POST',
               data: {
                  edit_id: $edit_id
               },
               success: function(data) {
                  result = JSON.parse(data);
                  console.log(result);
                  $('#id').val(result.id);
                  $('#fname').val(result.first_name);
                  $('#lname').val(result.last_name);
                  $('#email').val(result.email);
                  $('#phone').val(result.phone);
               }
            })
         })

         //update user
         $("#update").on('click', function(e) {
            if ($('#edit-form-data')[0].checkValidity()) {
               e.preventDefault();
               console.log($('#edit-form-data').serialize());
               $.ajax({
                  url: 'http://localhost:3000/pdo_ajax/action.php',
                  type: 'POST',
                  data: $('#edit-form-data').serialize() + "&action=update",
                  success: function(data) {
                     Swal.fire({
                        title: 'Update successfully!!',
                        icon: 'success'
                     })
                     $("#editModal").modal('hide');
                     $('#edit-form-data')[0].reset();
                     showAllUser();
                     console.log(data);
                  }
               })
            }
         })

         //delete user 
         $('body').on('click', '.deleBtn', function(e) {
            e.preventDefault();
            dele_id = $(this).attr('id');

            Swal.fire({
               title: 'Are you sure?',
               text: "You won't be able to revert this!",
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#3085d6',
               cancelButtonColor: '#d33',
               confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
               if (result.isConfirmed) {
                  $.ajax({
                     url: 'http://localhost:3000/pdo_ajax/action.php',
                     type: 'POST',
                     data: {
                        dele_id: dele_id
                     },
                     success: function(data) {
                        Swal.fire(
                           'Deleted!',
                           'Your file has been deleted.',
                           'success'
                        )
                        $("#editModal").modal('hide');
                        $('#edit-form-data')[0].reset();
                        showAllUser();
                     }
                  })
               }
            })
         })

         //show detail

         $('body').on('click', '.infoBtn', function(e) {
            e.preventDefault();
            detail_id = $(this).attr('id');
            $.ajax({
               url: 'http://localhost:3000/pdo_ajax/action.php',
               type: 'POST',
               data: {
                  detail_id: detail_id
               },
               success: function(data) {
                  result = JSON.parse(data);
                  Swal.fire({
                     title: '<strong>User Info: ID(' + result.id + ')</strong>',
                     type: 'info',
                     html: '<b>First Name : </b>' + result.first_name + '</br><b>Last Name: </b>' + result.last_name +
                        '</br><b>Email: </b>' + result.email + '</br><b>Phone: </b>' + result.phone,
                     showCancelButton: true
                  })
                  // console.log(result);
               }
            })
         })
      })
   </script>
</body>

</html>