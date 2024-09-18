<div class="container-fluid mt-3">
	<div class="card shadow-lg rounded-lg">
		<div class="card-body">
			<!-- Table -->
			<table class="table table-bordered table-striped table-hover">
				<thead class="thead-dark">
					<tr>
						<th class="text-center">Qty</th>
						<th class="text-center">Order</th>
						<th class="text-center">Amount</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$total = 0;
					include 'db_connect.php';
					$qry = $conn->query("SELECT * FROM order_list o INNER JOIN product_list p ON o.product_id = p.id WHERE order_id = " . $_GET['id']);
					while ($row = $qry->fetch_assoc()) :
						$total += $row['qty'] * $row['price'];
					?>
						<tr>
							<td class="text-center"><?= $row['qty'] ?></td>
							<td><?= htmlspecialchars($row['name']) ?></td>
							<td class="text-right">₹<?= number_format($row['qty'] * $row['price'], 2) ?></td>
						</tr>
					<?php endwhile; ?>
				</tbody>
				<tfoot>
					<tr class="font-weight-bold">
						<th colspan="2" class="text-right">TOTAL</th>
						<th class="text-right">₹<?= number_format($total, 2) ?></th>
					</tr>
				</tfoot>
			</table>
			<!-- Action Buttons -->
			<div class="text-center mt-4">
				<button class="btn btn-success" id="confirm" type="button" onclick="confirm_order()">Confirm Order</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<style>
	/* Custom styling */
	.card {
		border-radius: 10px;
		transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
	}

	.card:hover {
		transform: translateY(-5px);
		box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
	}

	/* Table styling */
	.table th, .table td {
		vertical-align: middle;
		font-size: 0.95rem;
	}

	.thead-dark th {
		background-color: #343a40;
		color: white;
	}

	/* Modal Footer - Hide */
	#uni_modal .modal-footer {
		display: none;
	}

	/* Button styling */
	.btn-success {
		background-color: #28a745;
		border-color: #28a745;
		color: white;
	}

	.btn-secondary {
		color: white;
	}
</style>

<script>
	function confirm_order() {
		start_load();
		$.ajax({
			url: 'ajax.php?action=confirm_order',
			method: 'POST',
			data: { id: '<?= $_GET['id'] ?>' },
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Order confirmed.");
					setTimeout(function() {
						location.reload();
					}, 1500);
				}
			}
		});
	}
</script>
