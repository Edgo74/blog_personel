<div class="container">
	<div class="row">

		<div class="card">
			<img class="card-img-top" src="<?= URL ?>images/<?php echo $posts['image']; ?>">
		</div>
		<div class="card-body">
			<h4 class="card-title"><?= $posts['title']; ?></h4>
			<p class="card-text"><?php echo $posts['description']; ?></p>
		</div>

	</div>
	<h4>Comments</h4>

	<?php foreach ($comments as $comment) : ?>
		<div class="media">
			<div class="media-left media-top">
				<img src="<?= URL ?>images/avatar.png" style="width: 100px;">

			</div>
			<div class="media-body">
				<strong><?php echo $comment['name']; ?></strong>
				<p><?php echo $comment['description']; ?></p>
			</div>

		</div>

	<?php endforeach; ?>
	<br>
	<h4>Add new Comment</h4>

	<form action="" method="POST">
		<div class="col-md-4">
			<div class="form-group">
				<label for="name">Name</label>
				<input type="text" name="name" class="form-control">
			</div>
			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" name="email" class="form-control">
			</div>
			<div class="form-group">
				<label for="subject">Subject</label>
				<input type="text" name="subject" class="form-control">
			</div>
			<div class="form-group">
				<label for="description">Description</label>
				<textarea name="description" class="form-control"></textarea>
			</div>
			<div class="form-group">
				<button type="submit" name="btnComment" class="btn btn-outline-success">Comment</button>
			</div>
		</div>

	</form>

</div>