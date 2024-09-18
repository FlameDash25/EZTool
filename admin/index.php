<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>EZTool</title>

  <?php
  session_start();
  if (!isset($_SESSION['login_id'])) header('location:login.php');
  include('./header.php');
  ?>

  <!-- Include Bootstrap for better styling -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Include FontAwesome for icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>

<style>
  body {
    background-color: #f8f9fa;
    font-family: Arial, sans-serif;
  }

  /* Preloader */
  #preloader2 {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    z-index: 99999;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  /* Toast notification styling */
  .toast {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1060;
    background-color: #17a2b8;
    color: white;
  }

  /* Back to top button styling */
  .back-to-top {
    position: fixed;
    bottom: 15px;
    right: 15px;
    background-color: #17a2b8;
    color: white;
    padding: 10px 15px;
    border-radius: 50%;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s;
  }

  .back-to-top:hover {
    background-color: #138496;
  }

  /* Modal styles */
  .modal-header {
    background-color: #17a2b8;
    color: white;
  }

  .modal-footer .btn {
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
  }

  /* Alignment improvements for main content */
  main {
    padding: 20px;
  }

  .container-fluid {
    padding: 20px;
  }

  .card {
    margin-top: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }

  .card-body {
    font-size: 1.2em;
    font-weight: 500;
    color: #495057;
  }
</style>

<body>
  <?php include 'topbar.php'; ?>

  <?php include 'navbar.php'; ?>

  <!-- Toast notification -->
  <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body text-white"></div>
  </div>

  <!-- Main content -->
  <main id="view-panel">
    <div class="container-fluid">
      <?php $page = isset($_GET['page']) ? $_GET['page'] : 'home'; ?>
      <?php include $page . '.php'; ?>
    </div>
  </main>

  <!-- Preloader -->
  <div id="preloader2" style="display: none;">
    <div class="spinner-border text-light" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>

  <!-- Back to top button -->
  <a href="#" class="back-to-top"><i class="fas fa-angle-up"></i></a>

  <!-- Confirmation Modal -->
  <div class="modal fade" id="confirm_modal" role="dialog">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
        </div>
        <div class="modal-body">
          <div id="delete_content"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for displaying dynamic content -->
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

  <!-- Include Bootstrap JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Preloader functions
    window.start_load = function () {
      document.getElementById('preloader2').style.display = 'flex';
    }

    window.end_load = function () {
      document.getElementById('preloader2').style.display = 'none';
    }

    // Modal loading function
    window.uni_modal = function (title = '', url = '') {
      start_load();
      $.ajax({
        url: url,
        error: function (err) {
          console.error(err);
          alert("An error occurred.");
        },
        success: function (resp) {
          if (resp) {
            $('#uni_modal .modal-title').html(title);
            $('#uni_modal .modal-body').html(resp);
            $('#uni_modal').modal('show');
            end_load();
          }
        }
      });
    }

    // Confirmation modal function
    window._conf = function (msg = '', func = '', params = []) {
      $('#confirm_modal #confirm').attr('onclick', func + "(" + params.join(',') + ")");
      $('#confirm_modal .modal-body').html(msg);
      $('#confirm_modal').modal('show');
    }

    // Toast notification function
    window.alert_toast = function (msg = 'TEST', bg = 'success') {
      $('#alert_toast').removeClass('bg-success bg-danger bg-info bg-warning');
      if (bg === 'success') $('#alert_toast').addClass('bg-success');
      if (bg === 'danger') $('#alert_toast').addClass('bg-danger');
      if (bg === 'info') $('#alert_toast').addClass('bg-info');
      if (bg === 'warning') $('#alert_toast').addClass('bg-warning');
      $('#alert_toast .toast-body').html(msg);
      $('#alert_toast').toast({ delay: 3000 }).toast('show');
    }

    $(document).ready(function () {
      $('#preloader').fadeOut('fast', function () {
        $(this).remove();
      });
    });
  </script>
</body>

</html>
