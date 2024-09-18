<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include('header.php');
include('admin/db_connect.php');

$query = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
foreach ($query as $key => $value) {
    if (!is_numeric($key))
        $_SESSION['setting_' . $key] = $value;
}
?>

<style>
    header.masthead {
        background: url(assets/img/<?= $_SESSION['setting_cover_img'] ?>) no-repeat center center;
        background-size: cover;
        padding: 10rem 0;
        text-align: center;
        color: white;
        position: relative;
    }

    .masthead h1 {
        font-size: 3rem;
        font-weight: 700;
    }

    .masthead .divider {
        width: 60px;
        height: 2px;
        background-color: #fff;
        margin: 20px auto;
    }

    /* Navbar Styles */
    .navbar {
        background-color: #343a40 !important;
    }

.navbar-brand {
    font-size: 1.5rem;
    color: #fff !important;
    display: flex;
    align-items: center; /* Align icon and text vertically */
}

.navbar-brand img.brand-icon {
    width: 45px; /* Set a fixed width to control the size of the icon */
    height: 23px; /* Keep the height auto to maintain the aspect ratio */
    margin-right: 5px; /* Add spacing between the icon and text */
    vertical-align: middle;
}


    .navbar-nav .nav-item .nav-link {
        color: #fff;
        font-weight: 500;
        margin-right: 1rem;
        transition: background-color 0.3s ease-in-out;
        padding: 0.5rem 1rem;
    }

    /* Hover Effect */
    .navbar-nav .nav-item .nav-link:hover {
        color: #fff;
        background-color: #17a2b8;
        border-radius: 5px;
    }

    /* Active/Clicked Effect */
    .navbar-nav .nav-item .nav-link.active {
        color: #fff;
        background-color: #17a2b8;
        border-radius: 5px;
    }

    /* Toast Notification */
    .toast {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1060;
    }

    /* Modal Header and Footer */
    .modal-header {
        background-color: #17a2b8;
        color: white;
    }

    .modal-footer .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
    }

    /* Footer Styles */
    footer.bg-light {
        background-color: #343a40 !important;
        color: white;
        padding: 2.5rem 0;
        text-align: center;
    }

    footer.bg-light a {
        color: #17a2b8;
        margin: 0 10px;
    }

    footer .small {
        color: #adb5bd;
    }

    footer .social-icons a {
        color: white;
        font-size: 1.25rem;
        margin: 0 10px;
        transition: color 0.3s ease-in-out;
    }

    footer .social-icons a:hover {
        color: #17a2b8;
    }

    /* Button Primary */
    .btn-primary {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }

    .btn-primary:hover {
        background-color: #138496;
        border-color: #138496;
    }

    /* Modal Body Padding */
    .modal-body {
        padding: 2rem;
    }

    /* Main Content Padding */
    main {
        padding: 4rem 0;
    }
</style>

<body id="page-top">
    <!-- Toast Notification -->
    <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body text-white"></div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top py-3" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="assets/img/your-icon.png">
                <img src="assets/img/icons.png" alt="Logo" class="brand-icon">
                <?= $_SESSION['setting_name'] ?>
            </a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=home"><i class="fas fa-home"></i> Home</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=cart_list"><span><i class="fa fa-shopping-cart"></i></span> Cart <span class="ml-2 badge badge-danger item_count"></span></a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=about"><i class="fas fa-info-circle"></i> Info</a></li>
                    <?php if (isset($_SESSION['login_user_id'])) : ?>
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="javascript:void(0)" id="logout_confirm">Logout <i class="fa fa-power-off"></i></a>
                        </li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" style="text-transform:capitalize" href="index.php?page=profile"><?= $_SESSION['login_first_name'] ?></a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=orders">Orders</a></li>
                    <?php else : ?>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="javascript:void(0)" id="login_now"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?php
        $page = isset($_GET['page']) ? $_GET['page'] : "home";
        include $page . '.php';
        ?>
    </main>

    <!-- Modals -->
    <div class="modal fade" id="confirm_modal" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Logout Confirmation</h5>
                </div>
                <div class="modal-body">
                    <div id="delete_content">Are you sure you want to log out?</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="confirm">Yes, Logout</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uni_modal" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Sidebar Modal -->
    <div class="modal fade" id="uni_modal_right" role="dialog">
        <div class="modal-dialog modal-full-height modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light py-5">
        <div class="container">
            <div class="small text-center text-muted">
                <span>Copyright © <?= date('Y') ?> - EZTool</span>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <?php include('footer.php') ?>
      <script>
        $(document).ready(function() {
            // Show confirmation modal when logout link is clicked
            $('#logout_confirm').click(function() {
                $('#confirm_modal').modal('show');
                $('#delete_content').html("Are you sure you want to log out?");
                
                // Handle confirmation button click
                $('#confirm').click(function() {
                    window.location.href = 'admin/ajax.php?action=logout2';
                });
            });
        });
    </script>
</body>
</html>
