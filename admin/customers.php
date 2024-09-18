<div class="container-fluid mt-3">
	<div class="row">
		<!-- Spacer for alignment on the right -->
		<div class="col-lg-9"></div>

		<!-- Search Bar on the Right -->
		<div class="col-lg-3 mb-3">
			<div class="input-group">
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
				<table class="table table-sm table-striped table-bordered table-hover" id="userTable">
					<thead class="thead-blue">
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Name</th>
							<th class="text-center">Email</th>
							<th class="text-center">Mobile</th>
							<th class="text-center">Address</th>
						</tr>
					</thead>
					<tbody>
						<?php
						include 'db_connect.php';
						$users = $conn->query("SELECT * FROM user_info ORDER BY user_id DESC");
						$i = 1;
						while ($row = $users->fetch_assoc()) :
						?>
							<tr class="hover-row">
								<td class="text-center"><?= $i++ ?></td>
								<td><?= strtoupper($row['first_name']).' '.strtoupper($row['last_name']) ?></td>
								<td><?= strtolower($row['email']) ?></td>
								<td><?= strtoupper($row['mobile']) ?></td>
								<td><?= strtoupper($row['address']) ?></td>
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

	/* Table Header with Blue Background */
	.thead-blue {
		background-color: var(--primary-blue);
		color: white;
	}

	/* Table Styling */
	.table-sm th, .table-sm td {
		padding: 0.3rem; /* Reduced padding for compact look */
		font-size: 0.875rem; /* Smaller font size */
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
	// Search Functionality
	$('#searchInput').on('keyup', function() {
		let value = $(this).val().toLowerCase();
		$('#userTable tbody tr').filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
</script>
