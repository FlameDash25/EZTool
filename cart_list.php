<header class="masthead">
  <div class="container h-100">
    <div class="row h-100 align-items-center justify-content-center text-center">
      <div class="col-lg-10 align-self-end mb-4 page-title py-5">
        <h3 class="text-white">Cart List</h3>
        <hr class="divider my-4" />
      </div>
    </div>
  </div>
</header>

<section class="page-section" id="menu">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <div class="sticky">
          <div class="card shadow-sm">
            <div class="card-body">
              <div class="row">
                <div class="col-md-8"><b>Items</b></div>
                <div class="col-md-4 text-right"><b>Total</b></div>
              </div>
            </div>
          </div>
        </div>

        <?php
        if (isset($_SESSION['login_user_id'])) {
          $data = "where c.user_id = '" . $_SESSION['login_user_id'] . "' ";
        } else {
          $ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] :  $_SERVER['REMOTE_ADDR'] ;
          $data = "where c.client_ip = '" . $ip . "' ";
        }
        $total = 0;
        $get = $conn->query("SELECT *,c.id as cid FROM cart c inner join product_list p on p.id = c.product_id " . $data);
        while ($row = $get->fetch_assoc()) :
          $total += ($row['qty'] * $row['price']);
        ?>

        <div class="card my-3 cart-item-card">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-md-4 text-center">
                <a href="admin/ajax.php?action=delete_cart&id=<?= $row['cid'] ?>" class="rem_cart btn btn-sm btn-outline-danger" data-id="<?= $row['cid'] ?>">
                  <i class="fa fa-trash"></i>
                </a>
                <img src="assets/img/<?= $row['img_path'] ?>" alt="" class="cart-img rounded mt-2">
              </div>
              <div class="col-md-4">
                <p><b><large><?= $row['name'] ?></large></b></p>
                <p class='truncate'><b><small>Desc: <?= $row['description'] ?></small></b></p>
                <p ><b><small>Unit Price: <b class="price">₹<?= number_format($row['price'], 2) ?></b></small></b></p>
                <p><small>QTY:</small></p>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary qty-minus" type="button" data-id="<?= $row['cid'] ?>">
                      <span class="fa fa-minus"></span>
                    </button>
                  </div>
                  <input type="number" readonly value="<?= $row['qty'] ?>" min=1 class="form-control text-center" name="qty">
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary qty-plus" type="button" data-id="<?= $row['cid'] ?>">
                      <span class="fa fa-plus"></span>
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-md-4 text-right">
  <b>
    <large class="price">₹<?= number_format($row['qty'] * $row['price'], 2) ?></large>
  </b>
</div>
            </div>
          </div>
        </div>

        <?php endwhile; ?>
      </div>

      <div class="col-md-4">
        <div class="sticky">
          <div class="card shadow-sm">
            <div class="card-body">
              <p><large>Total Amount</large></p>
              <hr>
            <p class="text-right"><b class="price">₹<?= number_format($total, 2) ?></b></p>
              <hr>
              <div class="text-center">
                <button class="btn btn-block btn-primary" type="button" id="checkout">Proceed to Checkout</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
  .masthead {
    background: url('assets/img/cart-bg.jpg') no-repeat center center;
    background-size: cover;
  }

  .divider {
    border-color: #ffffff;
  }

  .card {
    border-radius: 8px;
    transition: box-shadow 0.3s ease;
  }

  .card:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
  }

  .cart-img {
    max-width: 100%;
    max-height: 120px;
    transition: transform 0.3s ease;
  }

  .cart-img:hover {
    transform: scale(1.05);
  }

  .btn-outline-secondary:hover, .btn-outline-danger:hover {
    background-color: #f8f9fa;
    color: #212529;
  }

  .btn {
    transition: background-color 0.3s ease;
  }

  #checkout {
    background-color: #28a745;
    border-color: #28a745;
  }

  #checkout:hover {
    background-color: #218838;
  }
.price {
    font-size: 1rem;
    /* Larger font for visibility */
    color: #28a745;
    /* Use a green color to symbolize affordability */
    font-weight: bold;
    margin-bottom: 10px;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
}
  .sticky {
    position: sticky;
    top: 4.7em;
    z-index: 10;
    background: white;
  }

  .rem_cart {
    position: absolute;
    left: 0;
    top: 10px;
    transition: color 0.3s ease;
  }

  .rem_cart:hover {
    color: red;
  }

  .input-group-prepend button, .input-group-append button {
    transition: background-color 0.3s ease;
  }

  .input-group-prepend button:hover, .input-group-append button:hover {
    background-color: #007bff;
    color: #fff;
  }

  .cart-item-card {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.5s ease, transform 0.5s ease;
  }

  .cart-item-card.loaded {
    opacity: 1;
    transform: translateY(0);
  }
</style>

<script>
  $(document).ready(function() {
  // Animate cart items into view
  $('.cart-item-card').each(function(i) {
    setTimeout(function() {
      $('.cart-item-card').eq(i).addClass('loaded');
    }, 150 * i);
  });

  // Quantity Minus Button
  $('.qty-minus').click(function() {
    var qty = $(this).parent().siblings('input[name="qty"]').val();
    if (qty == 1) {
      return false;
    } else {
      $(this).parent().siblings('input[name="qty"]').val(parseInt(qty) - 1);
      update_qty(parseInt(qty) - 1, $(this).attr('data-id'));
    }
  });

  // Quantity Plus Button
  $('.qty-plus').click(function() {
    var qty = $(this).parent().siblings('input[name="qty"]').val();
    $(this).parent().siblings('input[name="qty"]').val(parseInt(qty) + 1);
    update_qty(parseInt(qty) + 1, $(this).attr('data-id'));
  });

  // Update quantity via AJAX
  function update_qty(qty, id) {
    start_load();
    $.ajax({
      url: 'admin/ajax.php?action=update_cart_qty',
      method: "POST",
      data: { id: id, qty: qty },
      success: function(resp) {
        if (resp == 1) {
          // Reload the page after updating the cart
          location.reload();
        }
      }
    });
  }

  // Checkout button action
  $('#checkout').click(function() {
    if ('<?= isset($_SESSION['login_user_id']) ?>' == 1) {
      location.replace("index.php?page=checkout");
    } else {
      uni_modal("Checkout", "login.php?page=checkout");
    }
  });
});

</script>
