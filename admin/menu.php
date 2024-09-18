<?php include('db_connect.php'); ?>

<div class="container-fluid mt-3">
    <div class="row">
        <!-- FORM Panel -->
        <div class="col-md-4">
            <form action="" id="manage-menu">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0 text-center">Menu Form</h5>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="id">
                        <div class="form-group">
                            <label for="name" class="control-label">Tool Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter tool name" required>
                        </div>
                        <div class="form-group">
                            <label for="description" class="control-label">Tool Description</label>
                            <textarea cols="30" rows="3" class="form-control" name="description" placeholder="Enter tool description" required></textarea>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="status" class="custom-control-input" id="availability" checked>
                                <label class="custom-control-label" for="availability">Available</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price" class="control-label">Price</label>
                            <input type="number" class="form-control text-right" name="price" step="any" placeholder="Enter price">
                        </div>
                        <div class="form-group">
                            <label for="img" class="control-label">Image</label>
                            <input type="file" class="form-control" name="img" onchange="displayImg(this,$(this))">
                        </div>
                        <div class="form-group text-center">
                            <img src="<?= isset($image_path) ? '../assets/img/' . $cover_img : '' ?>" alt="" id="cimg" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button class="btn btn-primary col-sm-5">Save</button>
                        <button class="btn btn-secondary col-sm-5 ml-1" type="button" onclick="$('#manage-menu').get(0).reset()">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- FORM Panel -->

        <!-- Table Panel -->
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Img</th>
                                <th class="text-center">Details</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $cats = $conn->query("SELECT * FROM product_list order by id asc");
                            while ($row = $cats->fetch_assoc()) :
                            ?>
                                <tr class="hover-row">
                                    <td class="text-center"><?= $i++ ?></td>
                                    <td class="text-center">
                                        <img src="<?= isset($row['img_path']) ? '../assets/img/' . $row['img_path'] : '' ?>" alt="" id="cimg" class="img-fluid rounded" style="max-height: 50px;">
                                    </td>
                                    <td>
                                        <p><strong>Name:</strong> <?= $row['name'] ?></p>
                                        <p><strong>Description:</strong> <span class="truncate"><?= $row['description'] ?></span></p>
                                       <p><strong>Price:</strong> <span style="color: #28a745;"><?= "₹" . number_format($row['price'], 2) ?></span></p>

                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-primary btn-sm edit_menu" type="button" data-id="<?= $row['id'] ?>" data-name="<?= $row['name'] ?>" data-status="<?= $row['status'] ?>" data-description="<?= $row['description'] ?>" data-price="<?= $row['price'] ?>" data-img_path="<?= $row['img_path'] ?>">Edit</button>
                                        <button class="btn btn-danger btn-sm delete_menu" type="button" data-id="<?= $row['id'] ?>">Delete</button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Table Panel -->
    </div>
</div>

<style>
    /* General Card Style */
    .card {
        margin-bottom: 1.5rem;
        border-radius: 10px;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .card-header {
        background-color: #007bff;
        color: white;
    }

    /* Hover Effect for Table Rows */
    .hover-row:hover {
        background-color: #f2f2f2;
        cursor: pointer;
    }

    /* Image Styling */
    img#cimg {
        max-height: 150px;
        max-width: 100%;
        border-radius: 10px;
    }

    .truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        font-size: small;
        color: #000000cf;
        font-style: italic;
    }

    /* Button Hover Effects */
    button {
        transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out;
    }

    button:hover {
        transform: scale(1.05);
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    /* Modal Style */
    .modal-header {
        background-color: #007bff;
        color: white;
    }
</style>

<script>
    function displayImg(input, _this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#cimg').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#manage-menu').submit(function(e) {
        e.preventDefault();
        start_load();
        $.ajax({
            url: 'ajax.php?action=save_menu',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Data successfully added", 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else if (resp == 2) {
                    alert_toast("Data successfully updated", 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            }
        })
    })

    $('.edit_menu').click(function() {
        start_load();
        var cat = $('#manage-menu');
        cat.get(0).reset();
        cat.find("[name='id']").val($(this).attr('data-id'));
        cat.find("[name='description']").val($(this).attr('data-description'));
        cat.find("[name='name']").val($(this).attr('data-name'));
        cat.find("[name='price']").val($(this).attr('data-price'));
        if ($(this).attr('data-status') == 1) {
            $('#availability').prop('checked', true);
        } else {
            $('#availability').prop('checked', false);
        }
        cat.find("#cimg").attr('src', '../assets/img/' + $(this).attr('data-img_path'));
        end_load();
    })

    $('.delete_menu').click(function() {
        _conf("Are you sure to delete this menu?", "delete_menu", [$(this).attr('data-id')]);
    })

    function delete_menu($id) {
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_menu',
            method: 'POST',
            data: { id: $id },
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Data successfully deleted", 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            }
        })
    }
</script>
