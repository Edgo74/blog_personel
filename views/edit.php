<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<form action="<?= URL ?>updatepost" method="POST" enctype="multipart/form-data">
				<div class="card">
					<div class="card-header">Edit post</div>
					<div class="card-body">
						<div class="form-group">
							<label for="title">Title</label>
							<input type="text" name="title_<?= locale ?>" class="form-control" value="<?php echo $posts['title']; ?>">
						</div>

						<div class="form-group">
							<label for="description">Description</label>
							<textarea cols="10" id="editor" name="description<?= locale ?>" class="form-control"><?php echo $posts['description']; ?></textarea>
						</div>

						<div class="form-group">
							<label for="image">Image</label>
							<input type="file" name="image" class="form-control">
							<img style="width: 180px;" src="<?= URL ?>images/<?php echo $posts['image'] ?>">
						</div>

						<div class="form-group">
							<input type="hidden" name="slug" value="<?php echo $posts['slug']; ?>">
							<button type="submit" name="btnUpdate" class="btn btn-primary">Update </button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

</div>
<script>
	ClassicEditor
		.create(document.querySelector('#editor'))
		.catch(error => {
			console.error(error);
		});
</script>
<style type="text/css">
	.card {
		margin-top: 10px;
	}
</style>