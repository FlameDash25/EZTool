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

<section class="page-section mb-4">
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="" id="checkout">
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
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Confirm</button>
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
            </div>
        </div>
    </div>
</section>

<!-- Toast Notifications -->
<div id="toast-container" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
    <div id="success-toast" class="toast bg-success text-white" style="display: none;" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <strong class="mr-auto">Success</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
        </div>
        <div class="toast-body">
            Order successfully placed!
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

<script>
    $(document).ready(function() {
        $('#checkout').submit(function(e) {
            e.preventDefault();
            
            // Validate form fields
            if (!this.checkValidity()) {
                $(this).addClass('was-validated');
                return;
            }

            $('#checkout').hide();  // Hide the form
            $('#loader').show();    // Show loader
            
            $.ajax({
                url: "ajax.php?action=save_order",
                method: 'POST',
                data: $(this).serialize(),
                success: function(resp) {
                    $('#loader').hide();  // Hide loader
                    if (resp == 1) {
                        $('#success-toast').fadeIn().delay(3000).fadeOut();
                        setTimeout(function() {
                            location.replace('index.php?page=home');
                        }, 1500);
                    } else {
                        $('#error-toast').fadeIn().delay(3000).fadeOut();
                        $('#checkout').show();  // Show form again if there's an error
                    }
                }
            });
        });
    });
</script>
