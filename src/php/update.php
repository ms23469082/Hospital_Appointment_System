<?php
session_start(); // Start the session
include "../php/dbcon.php";

// Generate CSRF token and store it in the session
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generate a random token
}

// Validate CSRF token
if (isset($_POST['submit'])) {
    // Check if CSRF token in the form matches the one stored in the session
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        // Invalid CSRF token, handle error or reject the request
        echo "CSRF Token Validation Failed!";
        exit();
    }

    // Proceed with form submission
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $id_number = $_POST['id_number'];
    $city = $_POST['city'];
    $department = $_POST['department'];
    $date = $_POST['date'];
    mysqli_query($dbcon, "INSERT INTO `appointment` (name, surname, id_number, city, department, date) VALUES ('$name', '$surname', '$id_number', '$city', '$department', '$date')");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!--Meta-->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hospital Appointment Database</title>
    <link rel="icon" type="image/x-icon" href="../../src/img/favicon.ico" />

    <!--CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css" />
</head>

<body data-bs-theme="dark" class="my-4">
    <!--Header-->
    <header class="container bg-warning bg-gradient rounded-2 p-1">
        <h1 class="h2 text-center text-dark">Hospital Appointment System</h1>
    </header>

    <!--Appointment-->
    <section class="container rounded-2 mt-3">
        <div class="row">
            <!--Input-->
            <form method="post" class="col-sm-6 col d-flex flex-column align-items-center justify-content-center gap-3">
                <!--Personal-->
                <div class="w-100 bg-black bg-opacity-25 rounded-2 p-4">
                    <h4>Personal Information</h4>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Name</div>
                        </div>
                        <input type="text" class="form-control" id="NameInput" name="name" required />
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">surname</div>
                        </div>
                        <input type="text" class="form-control" id="SurnameInput" name="surname" required />
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">ID Number</div>
                        </div>
                        <input type="text" class="form-control" id="IdInput" name="id_number" required />
                    </div>
                </div>

                <!--Appointment-->
                <div class="w-100 bg-black bg-opacity-25 rounded-2 p-4">
                    <h4>Appointment Information</h4>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">City</div>
                        </div>
                        <select class="form-control" id="CityInput" name="city" required>
                            <option disabled selected hidden></option>
                            <option>Antalya</option>
                            <option>Izmir</option>
                            <option>Tekirdag</option>
                            <option>Istanbul</option>
                            <option>Ankara</option>
                        </select>
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Department</div>
                        </div>
                        <select class="form-control" id="DepartmentInput" name="department" placeholder="Choose City"
                            required>
                            <option disabled selected hidden></option>
                            <option>Oral and Dental Diseases</option>
                            <option>Eye Diseases</option>
                            <option>Ear, Nose and Throat Diseases</option>
                            <option>General Surgery</option>
                            <option>Plastic Surgery</option>
                        </select>
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Date</div>
                        </div>
                        <input type="date" class="form-control" id="DateInput" name="date" required />
                    </div>
                </div>

                <!--Button-->
                <div class="container d-flex gap-2">
                    <button class="btn btn-outline-danger w-100 rounded-2 text-light" type="reset">Clear the Form</button>
                    <button class="btn btn-success w-100 rounded-2 text-light" name="submit" type="submit">Save the Appointment</button>
                    <!-- CSRF token input field -->
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                </div>
            </form>

            <!--Animation-->
            <div class="col-sm-6 col d-flex align-items-center justify-content-center">
                <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                <lottie-player src="https://assets7.lottiefiles.com/packages/lf20_x1gjdldd.json" mode="