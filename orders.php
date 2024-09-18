<!-- Masthead-->
<section class="page-section" id="menu">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-12 text-center">
                <h3 class="font-weight-bold text-uppercase text-primary">All Orders</h3>
            </div>
        </div>
        
        <!-- Search Bar -->
        <div class="row justify-content-center mb-4">
            <div class="col-lg-6">
                <form class="form-inline" method="POST" action="">
                    <div class="input-group w-100">
                        <input type="text" class="form-control" name="search" placeholder="Search orders by Name, Email, or Mobile" aria-label="Search" aria-describedby="search-button">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit" id="search-button">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <table class="table table-hover table-striped table-bordered text-center">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $user = $_SESSION['login_email'];
                                $i = 1;
                                include 'admin/db_connect.php';

                                // Add search functionality
                                if (isset($_POST['search'])) {
                                    $search = $_POST['search'];
                                    $qry = $conn->query("SELECT * FROM orders WHERE `email` = '$user' AND (`name` LIKE '%$search%' OR `email` LIKE '%$search%' OR `mobile` LIKE '%$search%')");
                                } else {
                                    $qry = $conn->query("SELECT * FROM orders WHERE `email`= '$user'");
                                }

                                while ($row = $qry->fetch_assoc()) :
                                ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $row['name'] ?></td>
                                        <td><?= $row['address'] ?></td>
                                        <td><?= $row['email'] ?></td>
                                        <td><?= $row['mobile'] ?></td>
                                        <?php if ($row['status'] == 1) : ?>
                                            <td><span class="badge badge-success px-3 py-2">Confirmed</span></td>
                                        <?php else : ?>
                                            <td><span class="badge badge-secondary px-3 py-2">For Verification</span></td>
                                        <?php endif; ?>
                                    </tr>
                                    <?php
                                    $total = 0;
                                    $qry2 = $conn->query("SELECT * FROM order_list o INNER JOIN product_list p ON o.product_id = p.id WHERE order_id = " . $row['id']);
                                    while ($row2 = $qry2->fetch_assoc()) :
                                        $total += $row2['qty'] * $row2['price'];
                                    ?>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td><strong>Item</strong></td>
                                            <td><?= $row2['name'] . ' x ' . $row2['qty'] ?></td>
                                            <td><strong><?= number_format($row2['qty'] * $row2['price'], 2) ?></strong></td>
                                            <td></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Custom Styles for Blue Theme -->
<style>
    .text-primary {
        color: #007bff !important;
    }

    .card {
        border-radius: 10px;
        border: 1px solid #007bff;
    }

    .table thead th {
        background-color: #007bff;
        color: #fff;
    }

    .table td {
        vertical-align: middle;
    }

    .badge-success {
        background-color: #28a745;
    }

    .badge-secondary {
        background-color: #6c757d;
    }

    .badge {
        font-size: 14px;
    }

    .card-body {
        padding: 2rem;
    }

    .mb-4 {
        margin-bottom: 1.5rem;
    }

    .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
    }

    .table-hover tbody tr:hover {
        background-color: #e9f7fe;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 255, 0.05);
    }

    .table-bordered td,
    .table-bordered th {
        border-color: #007bff;
    }

    /* Button Styles */
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
</style>
<script>
    $('#searchInput').on('keyup', function() {
    let value = $(this).val().toLowerCase();
    $('#userTable tbody tr').filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
});
    </script>
