<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Include Bootstrap CSS and FontAwesome CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">

  <style>
    .logo {
      margin: auto;
      font-size: 15px;
      background: white;
      padding: 5px 10px;
      border-radius: 50%;
      color: #000000b3;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .navbar {
      padding: 0;
    }
    .navbar .container-fluid {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .navbar .logo-container {
      display: flex;
      align-items: center;
    }
    .navbar .logout {
      display: flex;
      align-items: center;
      justify-content: flex-end;
    }
    @media (max-width: 768px) {
      .navbar .text-white.large-text {
        font-size: 16px;
      }
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-dark bg-primary fixed-top">
    <div class="container-fluid mt-2 mb-2">
      <div class="logo-container">
        <div class="logo">
          <i class="bi bi-person-circle admin-icon"></i>
        </div>
        <div class="ml-3 text-white large-text">
          <large><b><?= $_SESSION['setting_name']; ?></b></large>
        </div>
      </div>
      <div class="logout text-white">
        <a href="ajax.php?action=logout" class="text-white" onclick="return confirmLogout()">
          <?= $_SESSION['login_name'] ?> <i class="fa fa-power-off"></i>
        </a>
      </div>
    </div>
  </nav>

  <script>
    function confirmLogout() {
      return confirm('Are you sure you want to log out?');
    }
  </script>
</body>
</html>
