<!DOCTYPE html>
<html>

<head>
  <title>Blog</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="https://cdn.ckeditor.com/ckeditor5/11.2.0/classic/ckeditor.js"></script>


</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?= URL ?>home">Blog</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="<?= URL ?>home">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= URL ?>AddPost">Add Post</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= URL ?>dashboard">Dashboard</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Langue
          </a>
          <ul class="dropdown-menu">
            <nav>
              <?php $link_data = link_data;  ?>
              <?php foreach ($link_data as $link) : ?>

                <?php if ($link['is_current']) : ?>

                  <li>
                    <p class="dropdown-item"> <?= $link['label'] ?></p>
                  </li>

                <?php else : ?>

                  <li><a class="dropdown-item" href="<?= $link['url'] ?>"><?= $link['label'] ?></a></li>

                <?php endif; ?>

              <?php endforeach; ?>
            </nav>
          </ul>
        </li>

        <?php if (!Toolbox::estConnecte()) : ?>

          <li class="nav-item">
            <a class="nav-link" href="<?= URL ?>login">Login</a>
          </li>
        <?php else : ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= URL ?>logout">Logout</a>
          </li>

        <?php endif; ?>

      </ul>
    </div>
  </nav>
</body>

</html>