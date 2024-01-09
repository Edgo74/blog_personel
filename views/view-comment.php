<div class="container">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Name</th>
				<th>Subject</th>
				<th>Description</th>
				<th>Created</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php if (isset($comments)) : ?>
				<?php foreach ($comments as $comment) : ?>
					<tr>
						<td><?php echo $comment['name']; ?></td>
						<td><?php echo $comment['subject']; ?></td>
						<td><?php echo $comment['description']; ?></td>
						<td><?php echo date('Y-m-d', strtotime($comment['created_at'])); ?></td>
						<td>
							<form action="ApproveComments" method="POST">
								<input type="hidden" name="approveID" value="<?php echo $comment['id']; ?>">

								<button type="submit" class="btn btn-outline-success btn-sm" name="approveComment">Approve</button>
							</form>
							<form action="DeleteComments" method="POST">
								<input type="hidden" name="deleteID" value="<?php echo $comment['id']; ?>">

								<button type="submit" class="btn btn-outline-danger btn-sm" name="delete">Delete</button>
							</form>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
</div>