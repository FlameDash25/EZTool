<?php
include 'admin/db_connect.php';
// Check if the user has items in the cart
$chk = $conn->query("SELECT * FROM cart WHERE user_id = {$_SESSION['login_user_id']}")->num_rows;
if ($chk <= 0) {
    echo "<script>alert('You don\'t have an item in your cart yet.'); location.replace('./')</script>";
}
?>

<header class="masthead">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-10 align-self-end mb-4 page-title">
                <h3 class="text-white">Checkout</h3>
                <hr class="divider my-4" />
            </div>
        </div>
    </div>
</header>

<div class="container">
    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <form action="" id="checkout-frm">
                <h4 class="text-center mb-4">Confirm Delivery Information</h4>
                <div class="form-group">
                    <label for="first_name" class="control-label">Firstname</label>
                    <input type="text" name="first_name" id="first_name" required class="form-control" value="<?= $_SESSION['login_first_name'] ?>">
                    <div class="invalid-feedback">First name is required.</div>
                </div>
                <div class="form-group">
                    <label for="last_name" class="control-label">Lastname</label>
                    <input type="text" name="last_name" id="last_name" required class="form-control" value="<?= $_SESSION['login_last_name'] ?>">
                    <div class="invalid-feedback">Last name is required.</div>
                </div>
                <div class="form-group">
                    <label for="email" class="control-label">Email</label>
                    <input type="email" name="email" id="email" required class="form-control" value="<?= $_SESSION['login_email'] ?>">
                    <div class="invalid-feedback">Please enter a valid email address.</div>
                </div>
                <div class="form-group">
                    <label for="mobile" class="control-label">Contact</label>
                    <input type="text" name="mobile" id="mobile" required class="form-control" value="<?= $_SESSION['login_mobile'] ?>">
                    <div class="invalid-feedback">Contact number is required.</div>
                </div>
                <div class="form-group">
                    <label for="address" class="control-label">Address</label>
                    <textarea name="address" id="address" cols="30" rows="3" required class="form-control"><?= $_SESSION['login_address'] ?></textarea>
                    <div class="invalid-feedback">Address is required.</div>
                </div>

                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-primary btn-lg btn-block ripple">Place Order</button>
                </div>
            </form>

            <!-- Loader -->
            <div id="loader" style="display: none;">
                <div class="text-center mt-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2">Processing your order...</p>
                </div>
            </div>
            <div id="loader" style="display: none;">
                <div class="text-center mt-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2">Confirmed</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notifications -->
<div id="toast-container" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
    <div id="success-toast" class="toast bg-success text-white" style="display: none;" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <strong class="mr-auto">Success</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
        </div>
        <div class="toast-body">
            Order successfully placed! <br> Redirecting you to the homepage...
        </div>
    </div>
    <div id="error-toast" class="toast bg-danger text-white" style="display: none;" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-danger text-white">
            <strong class="mr-auto">Error</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
        </div>
        <div class="toast-body">
            Something went wrong. Please try again.
        </div>
    </div>
</div>

<style>
    /* Fade-in/out animation */
    .fade-in {
        animation: fadeIn 0.6s ease-in-out forwards;
    }
    
    .fade-out {
        animation: fadeOut 0.6s ease-in-out forwards;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }

    /* Ripple effect */
    .ripple {
        position: relative;
        overflow: hidden;
    }

    .ripple:after {
        content: '';
        display: block;
        position: absolute;
        top: 50%;
        left: 50%;
        width: 200%;
        height: 200%;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        transform: translate(-50%, -50%) scale(0);
        opacity: 0;
        pointer-events: none;
        transition: transform 0.6s ease, opacity 0.6s ease;
    }

    .ripple:active:after {
        transform: translate(-50%, -50%) scale(1);
        opacity: 1;
        transition: 0s;
    }

    /* Button hover effect */
    .btn-primary {
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transform: translateY(-3px);
    }
</style>

<script>
    $(document).ready(function() {
        $('#checkout-frm').submit(function(e) {
            e.preventDefault();

            // Validate form fields
            if (!this.checkValidity()) {
                $(this).addClass('was-validated');
                return;
            }

            $('#checkout-frm').addClass('fade-out');  // Fade out the form
            setTimeout(function() {
                $('#checkout-frm').hide();
                $('#loader').addClass('fade-in').fadeIn();  // Fade in the loader
            }, 600);

            $.ajax({
                url: "admin/ajax.php?action=save_order",
                method: 'POST',
                data: $(this).serialize(),
                success: function(resp) {
                    $('#loader').fadeOut();  // Hide loader
                    if (resp == "1") {  // Ensure the backend returns a string "1"
                        $('#success-toast').fadeIn().delay(3000).fadeOut();
                        setTimeout(function() {
                            location.replace('index.php?page=home');
                        }, 1500);
                    } else {
                        $('#error-toast').fadeIn().delay(3000).fadeOut();
                        $('#checkout-frm').removeClass('fade-out').fadeIn();  // Show form again if there's an error
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + error);  // Capture error for debugging
                    $('#error-toast').fadeIn().delay(3000).fadeOut();
                    $('#checkout-frm').removeClass('fade-out').fadeIn();  // Show form again if there's an error
                }
            });
        });
    });
</script>
