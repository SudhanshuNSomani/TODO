<!-- INSERT INTO `notes` (`Sno`, `Title`, `Description`, `TimeStamp`) VALUES (NULL, 'by', 'bad boii', current_timestamp()); -->

<?php
// connecting to the database
$insert = false;

$servername = "localhost";
$username = "root";
$password = "";
$database = "Notes";

$conn = mysqli_connect($servername, $username, $password, $database);


if (!$conn) {
  die("Sorry we failed to connect : " . mysqli_connect_error());
}

$title = "";
$description = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = $_POST['title'];
  $description = $_POST['description'];

}


if ($title != "" and $description != "") {
  $sqlInsert = "INSERT INTO `notes` (`Title`, `Description`) VALUES ('$title', '$description')";
  $result = mysqli_query($conn, $sqlInsert);

  if ($result) {
    $insert = true;
  } else {
    die("Sorry for interupttion " . mysqli_error($conn));
  }

}


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Todo List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
  <link rel="stylesheet" href="./style.css" />
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">

</head>

<body>


  <!-- Edit modal -->
  <!-- Button trigger modal -->
  <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
  </button> -->

  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editModalLabel">Edit Modal</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="index.php" method="post">
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" placeholder="Title" />
              <label for="title">Note Title</label>
            </div>
            <div class="form-floating mb-3">
              <textarea class="form-control" placeholder="Leave a comment here" id="descriptionEdit"
                name="descriptionEdit"></textarea>
              <label for="desc">Description</label>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

  <!-- navbar -->
  <nav class="navbar navbar-dark bg-dark ">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Offcanvas dark navbar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar"
        aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar"
        aria-labelledby="offcanvasDarkNavbarLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">TODO</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact US</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <?php
  if ($insert == true) {
    if ($result) {
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success</strong>Your note have been added successfully !<button
              type='button'
              class='btn-close'
              data-bs-dismiss='alert'
              aria-label='Close'
            ></button>
            </div>";
    }
  }
  ?>


  <!--Form-->
  <div class="container mt-3">
    <h2 class="mb-2">Keep a Note</h2>
    <form action="index.php" method="post">
      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="title" name="title" placeholder="Title" />
        <label for="title">Note Title</label>
      </div>
      <div class="form-floating mb-3">
        <textarea class="form-control" placeholder="Leave a comment here" id="description"
          name="description"></textarea>
        <label for="desc">Description</label>
      </div>
      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
  </div>

  <!-- notes -->



  <div class="container mt-5 mb-5">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.NO</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sqlSelect = "SELECT * FROM `notes`";
        $result = mysqli_query($conn, $sqlSelect);

        if (!$result) {
          die("Sorry there was an error : " . mysqli_error($conn));
        }
        $Sno = 0;
        while ($row = mysqli_fetch_assoc($result)) {
          $Sno += 1;
          echo "
          <tr>
            <th scope='row'> " . $Sno . "</th>
            <td> " . $row['Title'] . "</td>
            <td> " . $row['Description'] . "</td>
            <td><button class='edits btn btn-primary'>Edit</button> <a href=''>Del</a></td>
          </tr>";

        }
        ?>

      </tbody>

    </table>

  </div>

  <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
    crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>

  <script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
  <script src="script.js"></script>
</body>

</html>