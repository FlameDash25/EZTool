<style>
	/* Custom card styling */
	.card {
		border-radius: 10px;
		box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
	}

	.card-body {
		padding: 15px;
	}

	/* Compact Table Styling */
	.table {
		margin-bottom: 0;
		font-size: 0.85rem; /* Smaller font size */
	}

	.table th, .table td {
		padding: 8px; /* Reduce padding for smaller spacing */
		vertical-align: middle;
		text-align: center;
	}

	.table thead th {
		background-color: #007bff;
		color: white;
		border-bottom: 2px solid #dee2e6;
	}

	/* Badge Styling */
	.badge-success {
		background-color: #28a745;
		color: white;
	}

	.badge-secondary {
		background-color: #6c757d;
		color: white;
	}

	/* Button Styling */
	.btn-sm {
		padding: 0.25rem 0.5rem;
		font-size: 0.8rem; /* Smaller buttons */
	}

	/* Table Hover Effects */
	.table-hover tbody tr:hover {
		background-color: #f8f9fa;
	}

	/* Make Table Responsive */
	@media (max-width: 768px) {
		.table th, .table td {
			font-size: 0.75rem;
		}

		.btn {
			font-size: 0.7rem;
			padding: 0.2rem 0.4rem;
		}
	}
</style>

<div class="container-fluid">
	<div class="card">
		<div class="card-body">
			<h5 class="card-title mb-3">Order List</h5>
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Address</th>
						<th>Email</th>
						<th>Mobile</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					include 'db_connect.php';
					$qry = $conn->query("SELECT * FROM orders");
					while ($row = $qry->fetch_assoc()) :
					?>
						<tr>
							<td><?= $i++ ?></td>
							<td><?= htmlspecialchars($row['name']) ?></td>
							<td><?= htmlspecialchars($row['address']) ?></td>
							<td><?= htmlspecialchars($row['email']) ?></td>
							<td><?= htmlspecialchars($row['mobile']) ?></td>
							<?php if ($row['status'] == 1) : ?>
								<td><span class="badge badge-success">Confirmed</span></td>
							<?php else : ?>
								<td><span class="badge badge-secondary">For Verification</span></td>
							<?php endif; ?>
							<td>
								<button class="btn btn-sm btn-primary view_order" data-id="<?= $row['id'] ?>">View Order</button>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
	$('.view_order').click(function() {
		uni_modal('Order Details', 'view_order.php?id=' + $(this).attr('data-id'))
	})
</script>
