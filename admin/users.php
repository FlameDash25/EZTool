<?php
// Your PHP logic remains the same here.
?>

<div class="container-fluid mt-3">
	<div class="row">
		<div class="col-lg-12 d-flex justify-content-between">
			<button class="btn btn-blue-gradient btn-sm" id="new_user">
				<i class="fa fa-plus"></i> New User
			</button>

			<!-- Search Bar -->
			<div class="input-group col-md-4">
				<input type="text" class="form-control" id="searchInput" placeholder="Search users...">
				<div class="input-group-append">
					<span class="input-group-text"><i class="fa fa-search"></i></span>
				</div>
			</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="card col-lg-12 shadow-lg rounded-lg">
			<div class="card-body">
				<table class="table table-striped table-bordered table-hover" id="userTable">
					<thead class="thead-blue">
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Name</th>
							<th class="text-center">Username</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						include 'db_connect.php';
						$users = $conn->query("SELECT * FROM users order by name asc");
						$i = 1;
						while ($row = $users->fetch_assoc()) :
						?>
							<tr class="hover-row">
								<td class="text-center"><?= $i++ ?></td>
								<td><?= $row['name'] ?></td>
								<td><?= $row['username'] ?></td>
								<td class="text-center">
									<div class="btn-group">
										<button type="button" class="btn btn-blue btn-sm">Action</button>
										<button type="button" class="btn btn-blue btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<span class="sr-only">Toggle Dropdown</span>
										</button>
										<div class="dropdown-menu">
											<a class="dropdown-item edit_user" href="javascript:void(0)" data-id='<?= $row['id'] ?>'>Edit</a>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item delete_user" href="javascript:void(0)" data-id='<?= $row['id'] ?>'>Delete</a>
										</div>
									</div>
								</td>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<style>
	/* Blue Theme Colors */
	:root {
		--primary-blue: #007bff;
		--light-blue: #66b2ff;
		--dark-blue: #0056b3;
		--hover-blue: #00509e;
	}

	/* Blue Gradient Button */
	.btn-blue-gradient {
		background: linear-gradient(45deg, var(--primary-blue), var(--light-blue));
		color: white;
		border: none;
		transition: background-color 0.3s ease, transform 0.3s ease;
	}

	.btn-blue-gradient:hover {
		background: linear-gradient(45deg, var(--dark-blue), var(--hover-blue));
		transform: scale(1.05);
	}

	/* Blue Primary Buttons */
	.btn-blue {
		background-color: var(--primary-blue);
		border: none;
		color: white;
		transition: background-color 0.3s ease;
	}

	.btn-blue:hover {
		background-color: var(--hover-blue);
	}

	/* Table Header with Blue Background */
	.thead-blue {
		background-color: var(--primary-blue);
		color: white;
	}

	/* Table Styling */
	.table {
		margin-top: 10px;
		border-collapse: collapse;
		width: 100%;
	}

	.table-hover tbody tr:hover {
		background-color: #f0f8ff;
		cursor: pointer;
	}

	/* Card styling */
	.card {
		border-radius: 10px;
		transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
	}

	.card:hover {
		transform: translateY(-5px);
		box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
	}

	/* Dropdown Menu */
	.dropdown-menu {
		min-width: 100px;
	}

	/* Hover row effect */
	.hover-row:hover {
		background-color: #e3f2fd;
	}

	/* Search bar */
	.input-group .form-control {
		border-radius: 0.25rem;
	}

	.input-group .input-group-text {
		background-color: var(--primary-blue);
		color: white;
	}
</style>
<script>
// New User Modal
$('#new_user').click(function() {
    uni_modal('New User', 'manage_user.php');
});

// Edit User Modal
$('.edit_user').click(function() {
    uni_modal('Edit User', 'manage_user.php?id=' + $(this).attr('data-id'));
});

// Search Functionality
$('#searchInput').on('keyup', function() {
    let value = $(this).val().toLowerCase();
    $('#userTable tbody tr').filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
});

// Delete User Functionality
$('.delete_user').click(function() {
    _conf("Are you sure to delete this user?", "delete_user", [$(this).attr('data-id')]);
});

// Function to handle the actual delete
function delete_user(id) {
    start_load();
    $.ajax({
        url: 'ajax.php?action=delete_user',
        method: 'POST',
        data: { id: id },
        success: function(resp) {
            if (resp == 1) {
                alert_toast("User successfully deleted", 'success');
                setTimeout(function() {
                    location.reload();
                }, 1500);
            }
        }
    });
}
</script>
