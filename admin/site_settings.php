<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * from system_settings limit 1");
if ($qry->num_rows > 0) {
    foreach ($qry->fetch_array() as $k => $val) {
        $meta[$k] = $val;
    }
}
?>
<div class="container-fluid">
    <div class="card col-lg-12 shadow-sm mt-4">
        <div class="card-body">
            <h3 class="text-center text-primary mb-4">System Settings</h3>
            <form action="" id="manage-settings">
                <div class="form-group">
                    <label for="name" class="control-label font-weight-bold">System Name</label>
                    <input type="text" class="form-control rounded-pill" id="name" name="name" 
                           value="<?= isset($meta['name']) ? $meta['name'] : '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="email" class="control-label font-weight-bold">Email</label>
                    <input type="email" class="form-control rounded-pill" id="email" name="email" 
                           value="<?= isset($meta['email']) ? $meta['email'] : '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="contact" class="control-label font-weight-bold">Contact</label>
                    <input type="text" class="form-control rounded-pill" id="contact" name="contact" 
                           value="<?= isset($meta['contact']) ? $meta['contact'] : '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="about" class="control-label font-weight-bold">About Content</label>
                    <textarea name="about" class="form-control text-jqte" rows="5" 
                              style="border-radius: 15px;"><?= isset($meta['about_content']) ? $meta['about_content'] : '' ?></textarea>
                </div>
                <div class="form-group">
                    <label for="img" class="control-label font-weight-bold">Image</label>
                    <input type="file" class="form-control-file" name="img" onchange="displayImg(this, $(this))">
                </div>
                <div class="form-group text-center">
                    <img src="<?= isset($meta['cover_img']) ? '../assets/img/' . $meta['cover_img'] : '' ?>" 
                         alt="" id="cimg" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                </div>
                <div class="text-center">
                    <button class="btn btn-primary btn-block rounded-pill col-md-4 mx-auto">Save Settings</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        img#cimg {
            max-height: 150px;
            max-width: 150px;
            object-fit: cover;
            border-radius: 15px;
            border: 2px solid #ccc;
        }

        .form-control-file {
            padding: 10px 0;
        }

        .shadow-sm {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .text-jqte {
            border-radius: 15px !important;
        }

        .form-control {
            padding: 10px 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }

        label {
            margin-top: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 12px 20px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
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

        // Initialize jqte for the textarea
        $('.text-jqte').jqte();

        $('#manage-settings').submit(function(e) {
            e.preventDefault();
            start_load();
            $.ajax({
                url: 'ajax.php?action=save_settings',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                error: err => {
                    console.log(err);
                },
                success: function(resp) {
                    if (resp == 1) {
                        alert_toast('Data successfully saved.', 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                }
            })
        });
    </script>
</div>
