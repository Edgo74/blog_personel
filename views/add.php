<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<form action="<?= URL ?>ConfirmAddPost" method="POST" enctype="multipart/form-data">
				<div class="card">
					<div class="card-header">Add post</div>
					<div class="card-body">
						<div class="form-group">
							<label for="title">Title</label>
							<input type="text" name="title_en_GB" class="form-control">
						</div>

						<div class="form-group">
							<label for="title_fr">Titre en Français</label>
							<input type="text" name="title_fr" class="form-control">
						</div>

						<div class="form-group">
							<label for="description">Description</label>
							<textarea cols="10" id="editor" name="description_en_GB" class="form-control"></textarea>
						</div>

						<div class="form-group">
							<label for="description_fr">Description en français</label>
							<textarea cols="10" id="editor2" name="description_fr" class="form-control"></textarea>
						</div>

						<div class="form-group">
							<label for="image">Image</label>
							<input type="file" name="image" class="form-control">
						</div>

						<div class="form-group form-check-inline">
							<label for="image"><b>Choose tags</b>&nbsp;&nbsp;</label>
							<div class="row">
								<?php if (isset($tags)) : ?>
									<?php foreach ($tags as $tag) : ?>
										<div class="col-4">
											<input type="checkbox" name="tags[]" class="form-check-input" value="<?php echo $tag['id'] ?>"><?php echo $tag['tag']; ?>
										</div>
									<?php endforeach; ?>
								<?php else : ?>
									No tags to display
								<?php endif ?>
							</div>
						</div>

						<div class="form-group form-check-inline">
							<label for="customtag"><b>Add a Custom Tag</b>&nbsp;&nbsp;</label>
							<input type="text" class="form-control" name="customtag">
						</div>



						<div class="form-group">
							<button type="submit" name="btnSubmit" class="btn btn-primary">Submit</button>
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
	ClassicEditor
		.create(document.querySelector('#editor2'))
		.catch(error => {
			console.error(error);
		});
</script>
<style type="text/css">
	.card {
		margin-top: 10px;
	}
</style>