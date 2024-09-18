<?php
include 'admin/db_connect.php';
$qry = $conn->query("SELECT * FROM product_list WHERE id = " . $_GET['id']);
$product = $qry->fetch_array();
?>
<div class="container-fluid mt-4">
    <div class="card shadow-lg border-0 rounded">
        <!-- Product Image with Fallback -->
        <img src="assets/img/<?= !empty($product['img_path']) ? $product['img_path'] : 'default-image.png'; ?>" 
             class="card-img-top" alt="Product Image" 
             style="max-height: 300px; object-fit: cover;">
             
        <div class="card-body">
            <h5 class="card-title text-primary font-weight-bold"><?= $product['name'] ?></h5>
            
            <!-- Product Description with Show More/Less -->
            <p class="card-text text-muted" id="product-description">
                <?= $product['description'] ?>
            </p>
            <a href="javascript:void(0);" id="toggle-description" class="toggle-btn text-primary">Show More</a>
            
            <!-- Quantity Selector -->
            <div class="row align-items-center mt-3">
                <div class="col-md-2">
                    <label class="control-label font-weight-bold">Qty</label>
                </div>
                <div class="input-group col-md-8 mb-3">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary qty-btn" type="button" id="qty-minus">
                            <span class="fa fa-minus"></span>
                        </button>
                    </div>
                    <input type="number" value="1" min="1" class="form-control text-center" name="qty" readonly>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary qty-btn" type="button" id="qty-plus">
                            <span class="fa fa-plus"></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Add to Cart Button -->
            <div class="text-center">
                <button class="btn btn-primary btn-lg btn-block add-to-cart-btn" id="add_to_cart_modal">
                    <i class="fa fa-cart-plus"></i> Add to Cart
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Styles -->
<style>
    /* General Styling */
    .container-fluid {
        max-width: 600px;
    }

    /* Card Styling */
    .card {
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-img-top {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .card-title {
        font-size: 1.75rem;
        color: #007bff;
    }

    .card-text {
        font-size: 1rem;
        color: #6c757d;
        margin-bottom: 20px;
    }

    /* Show More/Less Button */
    .toggle-btn {
        font-size: 1rem;
        color: #007bff;
        text-decoration: underline;
        cursor: pointer;
        display: inline-block;
        margin-top: -10px;
        transition: color 0.3s ease;
    }

    .toggle-btn:hover {
        color: #0056b3;
    }

    /* Quantity Section */
    .qty-btn {
        background-color: #f8f9fa;
        border-radius: 50%;
        padding: 10px;
        transition: background-color 0.3s ease;
    }

    .qty-btn:hover {
        background-color: #e0e0e0;
    }

    /* Add to Cart Button */
    .add-to-cart-btn {
        background-color: #007bff;
        border: none;
        color: white;
        font-size: 1.1rem;
        padding: 10px;
        border-radius: 50px;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .add-to-cart-btn:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
    }

    /* Responsive */
    @media (max-width: 576px) {
        .card-title {
            font-size: 1.5rem;
        }

        .add-to-cart-btn {
            font-size: 1rem;
        }

        /* Mobile adjustments for Show More/Less */
        .toggle-btn {
            font-size: 0.9rem;
        }

        /* Mobile layout for quantity */
        .row.align-items-center {
            text-align: center;
        }
    }
</style>

<!-- JavaScript -->
<script>
    $(document).ready(function() {
        // Set maximum characters to show initially
        var maxLength = 100;
        var fullText = $('#product-description').text().trim();
        var truncatedText = fullText.substr(0, maxLength) + (fullText.length > maxLength ? '...' : '');

        // Display truncated text initially
        if (fullText.length > maxLength) {
            $('#product-description').text(truncatedText);
        }

        // Toggle Show More/Less functionality
        $('#toggle-description').click(function() {
            var currentText = $('#product-description').text().trim();
            if (currentText === truncatedText) {
                $('#product-description').text(fullText);
                $(this).text('Show Less');
            } else {
                $('#product-description').text(truncatedText);
                $(this).text('Show More');
            }
        });

        // Quantity Increment/Decrement
        $('#qty-minus').click(function() {
            var qty = $('input[name="qty"]').val();
            if (qty > 1) {
                $('input[name="qty"]').val(parseInt(qty) - 1);
            }
        });

        $('#qty-plus').click(function() {
            var qty = $('input[name="qty"]').val();
            $('input[name="qty"]').val(parseInt(qty) + 1);
        });

        // Add to Cart Functionality with Loading Spinner
        $('#add_to_cart_modal').click(function() {
            start_load(); // Show loading spinner
            $.ajax({
                url: 'admin/ajax.php?action=add_to_cart',
                method: 'POST',
                data: {
                    pid: '<?= $_GET['id'] ?>',
                    qty: $('[name="qty"]').val()
                },
                success: function(resp) {
                    if (resp == 1) {
                        alert_toast("Product successfully added to cart!", 'success');
                        $('.item_count').html(parseInt($('.item_count').html()) + parseInt($('[name="qty"]').val()));
                        $('.modal').modal('hide');
                    }
                    end_load(); // Hide loading spinner
                }
            });
        });

        // Start and End Load Spinner
        function start_load() {
            $('body').append('<div id="preloader2"></div>');
        }

        function end_load() {
            $('#preloader2').fadeOut('fast', function() {
                $(this).remove();
            });
        }

        // Toast Notification Function
        function alert_toast(message, type) {
            var bgColor = type === 'success' ? '#28a745' : '#dc3545';
            $('body').append(`
                <div class="toast" style="position: fixed; top: 10px; right: 10px; background-color: ${bgColor}; color: white; padding: 15px; border-radius: 5px; z-index: 9999;">
                    ${message}
                </div>
            `);
            setTimeout(function() {
                $('.toast').fadeOut(function() {
                    $(this).remove();
                });
            }, 3000);
        }
    });
</script>
