<?php
require_once 'Database.php';

$db = new Database();
if (isset($_POST['action']) && $_POST['action'] == 'view') {
   $output = '';
   $data = $db->read();
   if ($db->totalRowCount() > 0) {
      $output .= '<table class="table table-striped table-bordered table-sm">
                     <thead>
                        <tr class="text-center">
                           <th>Id</th>
                           <th>First Name</th>
                           <th>Last Name</th>
                           <th>E-Mail</th>
                           <th>Phone</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody class="text-center text-secondary">';
      foreach ($data as $row) {
         $output .= "<tr class='text-center text-secondary'>
                        <td>" . $row['id'] . "</td>
                        <td>" . $row['first_name'] . "</td>
                        <td>" . $row['last_name'] . "</td>
                        <td>" . $row['email'] . "</td>
                        <td>" . $row['phone'] . "</td>
                        <td>
                           <a href='#' class='btn btn-info infoBtn' id=" . $row['id'] . ">Detail</a>
                           <a href='#' data-toggle='modal' id=" . $row['id'] . " data-target='#editModal' class='btn btn-secondary editBtn'>Edit</a>
                           <a href='#' id=" . $row['id'] . " class='btn btn-danger deleBtn'>Delete</a>
                        </td></tr>
         ";
      }
      $output .= `</tbody></table>`;
      echo $output;
   } else {
      echo '<h3>No any user present in the database</h3>';
   }
}

if (isset($_POST['action']) && $_POST['action'] == 'insert') {
   $fname = $_POST['fname'];
   $lname = $_POST['lname'];
   $email = $_POST['email'];
   $phone = $_POST['phone'];

   $db->insert($fname, $lname, $email, $phone);
}

if (isset($_POST['edit_id'])) {
   $id = $_POST['edit_id'];
   $row = $db->getUserId($id);
   echo json_encode($row);
}

if (isset($_POST['action']) && $_POST['action'] == 'update') {
   $id = $_POST['id'];
   $fname = $_POST['fname'];
   $lname = $_POST['lname'];
   $email = $_POST['email'];
   $phone = $_POST['phone'];

   $db->update($id, $fname, $lname, $email, $phone);
}

if (isset($_POST['dele_id'])) {
   $id = $_POST['dele_id'];
   $db->delete($id);
}

if (isset($_POST['detail_id'])) {
   $id = $_POST['detail_id'];
   $row = $db->getUserId($id);
   echo json_encode($row);
}


if (isset($_GET['export']) && $_GET['export'] == 'excel') {
   header("Content-Type: application/xls");
   header("Content-Disposition: attachment; filename: users.xls");
   header("Pragma: no-cache");
   header("Expires: 0");

   $data = $db->read();
   echo "<table border='1'>";
   echo '<tr><th>Id</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th>';

   foreach ($data as $row) {
      echo '<tr>
               <td>' . $row['id'] . '</td>
               <td>' . $row['first_name'] . '</td>
               <td>' . $row['last_name'] . '</td>
               <td>' . $row['email'] . '</td>
               <td>' . $row['phone'] . '</td>
            </tr>';
   }
   echo '</table>';
}