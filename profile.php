<!-- Edit Profile Section -->
<section class="page-section" id="menu">
<?php
if (isset($_POST['updateProfile'])) {
    $userId = $_POST['userId'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];

    // Update the user's information in the database
    $sql = "UPDATE `user_info` SET `first_name`='$first_name', `last_name`='$last_name', `mobile`='$mobile', `address`='$address' WHERE `user_id`='$userId'";
    
    if ($conn->query($sql)) {
        // Update session variables after successful update
        $_SESSION['login_first_name'] = $first_name;
        $_SESSION['login_last_name'] = $last_name;
        $_SESSION['login_mobile'] = $mobile;
        $_SESSION['login_address'] = $address;

        // Use JavaScript to show a success alert and redirect back to the previous page
        echo '<script type="text/javascript">
                alert("Profile updated successfully!");
                window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";
              </script>';
        exit();
    } else {
        // Handle the error case
        echo "Error updating profile: " . $conn->error;
    }
}
?>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card mt-5 shadow-lg">
                    <div class="card-header bg-info text-white text-center">
                        <h3>Edit Profile</h3>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST">
                            <input type="hidden" name="userId" value="<?= $_SESSION['login_user_id']; ?>">

                            <!-- First Name -->
                            <div class="form-group">
                                <label for="first_name" class="control-label">First Name</label>
                                <input type="text" name="first_name" required class="form-control" value="<?= $_SESSION['login_first_name']; ?>">
                            </div>

                            <!-- Last Name -->
                            <div class="form-group">
                                <label for="last_name" class="control-label">Last Name</label>
                                <input type="text" name="last_name" required class="form-control" value="<?= $_SESSION['login_last_name']; ?>">
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email" class="control-label">Email</label>
                                <input type="email" name="email" required class="form-control" value="<?= $_SESSION['login_email']; ?>">
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <label for="password" class="control-label">Password</label>
                                <input type="password" name="password" required class="form-control" value="<?= $_SESSION['login_password']; ?>">
                            </div>

                            <!-- Mobile -->
                            <div class="form-group">
                                <label for="mobile" class="control-label">Mobile</label>
                                <input type="text" name="mobile" required class="form-control" value="<?= $_SESSION['login_mobile']; ?>">
                            </div>

                            <!-- Address -->
                            <div class="form-group">
                                <label for="address" class="control-label">Address</label>
                                <textarea cols="30" rows="3" name="address" required class="form-control"><?= $_SESSION['login_address']; ?></textarea>
                            </div>

                            <!-- Update Button -->
                            <div class="text-center">
                                <button class="btn btn-info btn-lg" name="updateProfile">UPDATE</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .card {
        border-radius: 10px;
        border: none;
    }

    .card-header {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .form-control {
        border-radius: 8px;
        box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.1);
    }

    .btn-info {
        border-radius: 25px;
        padding: 10px 30px;
        font-size: 1rem;
        transition: all 0.3s ease-in-out;
    }

    .btn-info:hover {
        background-color: #138496;
        border-color: #138496;
    }

    textarea.form-control {
        resize: none;
    }
</style>
