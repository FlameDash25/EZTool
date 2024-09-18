<style>
  /* Sidebar Styling */
  #sidebar {
    margin-top: 26px;
    padding-top: 20px;
    background-color: #2C3E50; /* Darker navy blue */
    height: 100vh;
    position: fixed;
    left: 0;
    width: 220px;
    color: white;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
    border-radius: 0 10px 10px 0;
    transition: all 0.3s ease-in-out; /* Smooth transitions */
  }

  /* Sidebar Links */
  .sidebar-list {
    padding: 0;
    margin: 0;
    list-style-type: none;
  }

  .sidebar-list a {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    color: #ecf0f1; /* Lighter text */
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: background-color 0.2s ease, color 0.2s ease;
    border-radius: 0 30px 30px 0;
    margin-bottom: 5px;
  }

  /* Hover & Active States */
  .sidebar-list a:hover,
  .sidebar-list a.active {
    background-color: #1ABC9C; /* Soft teal color for hover */
    color: #ffffff;
    box-shadow: inset 5px 0 0 rgba(0, 0, 0, 0.1); /* Subtle shadow on hover */
  }

  /* Sidebar Icons */
  .icon-field {
    margin-right: 10px;
    font-size: 18px;
  }

  /* Sidebar toggle for small screens */
  @media (max-width: 768px) {
    #sidebar {
      width: 200px;
      left: -230px; /* Hidden by default */
    }

    #sidebar.active {
      left: 0; /* Show sidebar */
    }

    .sidebar-list a {
      font-size: 13px;
    }
  }

  /* Sidebar Toggle Button */
  #sidebar-toggle {
    position: absolute;
    top: 20px;
    left: 240px;
    font-size: 24px;
    color: #2C3E50;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  #sidebar-toggle:hover {
    color: #1ABC9C;
  }

  /* Improved spacing for mobile */
  @media (max-width: 768px) {
    #sidebar-toggle {
      left: 200px;
    }
  }
</style>

<!-- Sidebar toggle button -->
<div id="sidebar-toggle">
  <i class="fas fa-bars"></i>
</div>

<!-- Sidebar -->
<nav id="sidebar" class="mx-lt-5 bg-primary">
  <ul class="sidebar-list">
    <li><a href="index.php?page=home" class="nav-item nav-home">
      <span class="icon-field"><i class="fas fa-home"></i></span> Home
    </a></li>
    <li><a href="index.php?page=orders" class="nav-item nav-orders">
      <span class="icon-field"><i class="fas fa-box-open"></i></span> Orders
    </a></li>
    <li><a href="index.php?page=menu" class="nav-item nav-menu">
      <span class="icon-field"><i class="fas fa-list-alt"></i></span> Products Management
    </a></li>
    <?php if ($_SESSION['login_type'] == 1) : ?>
      <li><a href="index.php?page=users" class="nav-item nav-users">
        <span class="icon-field"><i class="fas fa-user-cog"></i></span> Users
      </a></li>
      <li><a href="index.php?page=customers" class="nav-item nav-customers">
        <span class="icon-field"><i class="fas fa-users"></i></span> Customers
      </a></li>
      <li><a href="index.php?page=site_settings" class="nav-item nav-site_settings">
        <span class="icon-field"><i class="fas fa-cog"></i></span> Site Settings
      </a></li>
    <?php endif; ?>
  </ul>
</nav>

<script>
  // Toggle sidebar visibility on smaller screens
  $('#sidebar-toggle').click(function() {
    $('#sidebar').toggleClass('active');
  });

  // Highlight the current page in the sidebar
  $('.nav-<?= isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active');
</script>
