<div class="container">
    <div class="row">
        <div class="col-md-8">
            <?php if (isset($_GET['keyword'])) {
                echo 'Search for:' . '<i>' . $_GET['keyword'] . '</i>';
            } ?>
            <?php if (isset($posts)) : ?>
                <?php foreach ($posts as $post) : ?>
                    <div class="media">
                        <div class="media-left media-top">
                            <img src="<?= URL ?>images/<?php echo $post['image']; ?>" class="media-object" style="width:200px;">
                            <p>
                                Created:<?php echo date('Y-m-d', strtotime($post['created_at'])); ?>
                            </p>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><a href="<?= URL ?>view/<?php echo $post['slug']; ?>"><?php echo $post['title']; ?></a></h4>
                            <div class="AllPosts">
                                <p><?php echo htmlspecialchars_decode($post['description']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else : ?>
                No posts to display
            <?php endif ?>

            <?php
            $_GET['page'] = isset($_GET['page']) ? $_GET['page'] : 1;

            $page = $_GET['page'];

            $pageLink = "<ul class='pagination'>";
            if ($page > 1) {
                $pageLink .= "<a class='page-link' href='" . URL . "home/page=1'>First</a>";
                $pageLink .= "<a class='page-link' href='" . URL . "home/page=" . ($page - 1) . "'><<<</a>";
            }

            for ($i = 1; $i <= $totalPages; $i++) {
                $pageLink .= "<a class='page-link' href='" . URL . "home/page=" . $i . "'>" . $i . "</a>  ";
            }

            if ($page <= $totalPages) {
                $pageLink .= "<a class='page-link' href='" . URL . "home/page="  . ($page + 1) . "'>>>></a>";
                $pageLink .= "<a class='page-link' href='" . URL . "home/page="  . $totalPages . "'>Last</a>";
            }

            echo $pageLink . "</ul>";
            ?>

        </div>

        <div class="col-md-4">
            <h4>Browse by Tags</h4>
            <p>
                <?php if (isset($tags)) : ?>
                    <?php foreach ($tags as $tag) : ?>
                        <a href="<?= URL ?>home/tag=<?php echo urlencode($tag["tag"]); ?>"><button type="button" class="btn btn-outline-warning btn-sm">
                                <?php echo $tag['tag']; ?>
                            </button></a>
                    <?php endforeach; ?>


                <?php else : ?>
                    No tags to display
                <?php endif ?>
            </p>
            <p>
            <h4>Search Posts</h4>
            <form action="" method="GET">
                <input type="text" name="keyword" class="form-control" placeholder="search...">
            </form>
            </p>

            <h4>Popular posts</h4>
            <?php if (isset($popularposts)) : ?>
                <?php foreach ($popularposts as $p) : ?>
                    <p>
                        <a href="<?= URL ?>view/<?php echo $p['slug']; ?>" style="color:black;border-bottom: 1px dashed green;"><?php echo $p['title']; ?></a>
                    </p>
                <?php endforeach; ?>
            <?php else : ?>
                No posts to display
            <?php endif ?>

        </div>


    </div>
</div>


<style type="text/css">
    body {
        text-align: justify;
    }

    img {
        margin-right: 10px;
    }

    .media {
        margin-top: 10px;
    }

    .btn-group-sm>.btn,
    .btn-sm {
        padding: .25rem .5rem;
        font-size: .875rem;
        line-height: 1.5;
        border-radius: .2rem;
        margin-top: 12px;
    }
</style>

<script>
    document.querySelectorAll('.AllPosts').forEach(paragraph => {
        const content = paragraph.innerHTML;
        const maxLength = 200; // Nombre maximum de caractères à afficher
        const trimmedContent = content.substring(0, maxLength);
        paragraph.innerHTML = trimmedContent + '...';
    });
</script>