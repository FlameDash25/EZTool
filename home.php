<!-- Masthead-->
<header class="masthead">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-10 align-self-end mb-4 page-title py-5">
                <h3 class="text-white">Welcome to <?= $_SESSION['setting_name']; ?></h3>
                <hr class="divider my-4 bg-light" />
            </div>
        </div>
    </div>
</header>

<!-- Search Bar Section -->
<section class="page-section bg-light" id="menu">
    <div class="container">
        <!-- Bootstrap Search Form -->
        <div class="row mb-5">
            <div class="col-lg-12">
                <form class="form-inline d-flex justify-content-center">
                    <div class="input-group shadow-lg" style="width: 50%;">
                        <!-- Reduced width for smaller input -->
                        <input type="text" id="search-input" class="form-control" placeholder="Search products..."
                            aria-label="Search" aria-describedby="button-search">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="button-search">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Product Listing -->
        <div class="row" id="menu-field">
            <?php
            include 'admin/db_connect.php';
            $qry = $conn->query("SELECT * FROM product_list ORDER BY rand()");
            while ($row = $qry->fetch_assoc()) :
            ?>
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4 product-item">
                <div class="card menu-item h-100 shadow-lg border-2">
                    <div class="card-img-top"
                        style="background:url('assets/img/<?= $row['img_path'] ?>'); background-repeat:no-repeat; background-size:cover; height:250px; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title text-primary font-weight-bold"><?= $row['name'] ?></h5>
                        <p class="card-text description"><?= $row['description'] ?></p>
                        <p class="card-text price">₹<?= number_format($row['price'], 2) ?></p>

                    </div>
                    <div class="card-footer bg-white text-center">
                        <button class="btn btn-sm btn-outline-primary view_prod" data-id="<?= $row['id'] ?>"> View
                        </button>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- JavaScript for Modal and Search Functionality -->
<script>
// Search Functionality
document.getElementById('search-input').addEventListener('keyup', function() {
    var filter = this.value.toLowerCase();
    var products = document.querySelectorAll('.product-item');

    products.forEach(function(product) {
        var title = product.querySelector('.card-title').textContent.toLowerCase();
        if (title.includes(filter)) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
});

// Modal View for Products
$('.view_prod').click(function() {
    uni_modal_right('Product', 'view_prod.php?id=' + $(this).attr('data-id'));
});
</script>

<!-- Additional CSS -->
<style>
/* Masthead Styling */
.masthead {
    height: 60vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #343a40;
}

.masthead h3 {
    font-size: 2.5rem;
    letter-spacing: 2px;
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
}

.divider {
    width: 80px;
    height: 4px;
    background-color: #fff;
    margin: auto;
}

/* Card Styling */
.menu-item {
    border-radius: 15px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    border: 2px solid rgba(0, 0, 0, 0.1);
}

.menu-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 32px rgba(0, 0, 0, 0.3);
}

.menu-item .card-title {
    font-size: 1.25rem;
    margin-bottom: 10px;
    color: #007bff;
}

/* Description Styling */
.description {
    font-size: 0.95rem;
    margin-bottom: 20px;
    max-height: 4.5rem;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    word-wrap: break-word;
    color: #6c757d;
}

.menu-item .card-footer {
    border-top: none;
    background-color: #f8f9fa;
}

/* Price Styling */
.price {
    font-size: 1.25rem;
    /* Larger font for visibility */
    color: #28a745;
    /* Use a green color to symbolize affordability */
    font-weight: bold;
    margin-bottom: 10px;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
}

/* Button Styling */
.btn-outline-primary {
    border-color: #007bff;
    color: #007bff;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background-color: #007bff;
    color: #fff;
}

/* Search bar styling */
#search-input {
    border-radius: 50px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
}

/* Truncate Description */
.truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Responsive Design */
@media (max-width: 768px) {
    .masthead h3 {
        font-size: 2rem;
    }

    .menu-item {
        margin-bottom: 20px;
    }
}
</style>