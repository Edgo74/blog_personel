<div class="container">
	<h2>All Posts</h2>
	<a href="<?= URL ?>Comments" style="float:right;">comments</a>

	</h2>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Title</th>
				<th>Description</th>
				<th>Created at</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php if (isset($posts)) : ?>
				<?php foreach ($posts as $post) : ?>
					<tr>
						<td><?php echo $post['title']; ?></td>
						<td><?php echo substr($post['description'], 0, 20); ?></td>
						<td><?php echo date('Y-m-d', strtotime($post['created_at'])); ?></td>
						<td>
							<a href="<?= URL ?>view/<?php echo $post['slug']; ?>"><button type="submit" class="btn btn-outline-success btn-sm">View</button></a>
							<a href="<?= URL ?>edit/<?php echo $post['slug']; ?>"><button type="submit" class="btn btn-outline-primary btn-sm">Edit</button></a>
							<form action="<?= URL ?>deletepost" method="POST">
								<input type="hidden" name="slug" value="<?php echo $post['slug']; ?>">
								<button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('voulez-vous vraiment supprimer ce post ? ')">Delete</button>
							</form>
						</td>
					</tr>
				<?php endforeach ?>
			<?php else : ?>
				<p>No posts here !</p>
			<?php endif; ?>
		</tbody>
	</table>

	<?php

	if (!isset($_GET['tag'])) {
		if (!isset($_GET['page'])) {
			$_GET['page'] = 1;
		}


		$page = $_GET['page'];
		$pageLink = "<ul class='pagination'>";
		if ($page > 1) {
			$pageLink .= "<a class='page-link' href='index.php?mapage=dashboard&page=1'>First</a>";
			$pageLink .= "<a class='page-link' href='index.php?mapage=dashboard&page=" . ($page - 1) . "'><<<</a>";
		}

		for ($i = 1; $i <= $totalPages; $i++) {
			$pageLink .= "<a class='page-link' href='index.php?mapage=dashboard&page=" . $i . "'>" . $i . "</a>  ";
		}

		if ($page <= $totalPages) {
			$pageLink .= "<a class='page-link' href='index.php?mapage=dashboard&page=" . ($page + 1) . "'>>>></a>";
			$pageLink .= "<a class='page-link' href='index.php?mapage=dashboard&page=" . $totalPages . "'>Last</a>";
		}

		echo $pageLink . "</ul>";
	}
	?>

</div>