<?php session_start() ?>

<div class="container-fluid position-relative">
	
   
    <form action="" id="login-frm">
        <div class="form-group">
            <label for="" class="control-label">Email</label>
            <input type="email" name="email" required="" class="form-control">
        </div>
        <div class="form-group">
            <label for="" class="control-label">Password</label>
            <div class="position-relative">
                <input type="password" name="password" required="" class="form-control" id="password-field">
                <div class="md-form float-right w-25 text-right position-absolute" style="top: 50%; transform: translateY(-50%); right: 10px;">
                    <a id="showPassword" class="password-toggle"> <i class="fas fa-eye"></i></a>
                    <a id="hidePassword" class="password-toggle d-none"> <i class="fas fa-eye-slash"></i></a>
                </div>
            </div>
            <small><a href="javascript:void(0)" id="new_account">Create New Account</a></small>
        </div>
        <button class="button btn btn-info btn-sm">Login</button>
		
    </form>
</div>

<style>
    #uni_modal .modal-footer {
        display: none;
    }

    .password-toggle {
        cursor: pointer;
    }

    .position-relative {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        right: 10px;
    }

    .container-fluid {
        position: relative;
    }

    .close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 1.5rem;
        background: transparent;
        border: none;
        color: #000;
        cursor: pointer;
    }
</style>

<script>
    $('#new_account').click(function() {
        uni_modal("Create an Account", 'signup.php?redirect=index.php?page=checkout')
    })

    $('#login-frm').submit(function(e) {
        e.preventDefault()
        $('#login-frm button[type="submit"]').attr('disabled', true).html('Logging in...');
        if ($(this).find('.alert-danger').length > 0)
            $(this).find('.alert-danger').remove();
        $.ajax({
            url: 'admin/ajax.php?action=login2',
            method: 'POST',
            data: $(this).serialize(),
            error: err => {
                console.log(err)
                $('#login-frm button[type="submit"]').removeAttr('disabled').html('Login');
            },
            success: function(resp) {
                if (resp == 1) {
                    location.href = '<?= isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php?page=home' ?>';
                } else {
                    $('#login-frm').prepend('<div class="alert alert-danger">Email or password is incorrect.</div>')
                    $('#login-frm button[type="submit"]').removeAttr('disabled').html('Login');
                }
            }
        })
    })

    // Show/Hide Password
    $('#showPassword').click(function() {
        $('#password-field').attr('type', 'text');
        $('#showPassword').addClass('d-none');
        $('#hidePassword').removeClass('d-none');
    });

    $('#hidePassword').click(function() {
        $('#password-field').attr('type', 'password');
        $('#hidePassword').addClass('d-none');
        $('#showPassword').removeClass('d-none');
    });

    // Close Form
    $('#closeForm').click(function() {
        $(this).closest('.container-fluid').hide(); // Or use .remove() to remove it from the DOM
    });
</script>
