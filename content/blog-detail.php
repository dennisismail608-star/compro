<?php
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Ambil detail blog
$blogDetail = null;
if ($id) {
    $queryDetail = mysqli_query($koneksi, "SELECT categories.name, blogs.* FROM blogs
        JOIN categories ON categories.id = blogs.id_category
        WHERE blogs.id = '$id'");

    if ($queryDetail && mysqli_num_rows($queryDetail) > 0) {
        $blogDetail = mysqli_fetch_assoc($queryDetail);
    }
}

// Ambil recent blog (kecuali yang sedang dibuka)
$rowRecentBlog = [];
$queryRecent = mysqli_query($koneksi, "SELECT categories.name, blogs.* FROM blogs
    JOIN categories ON categories.id = blogs.id_category
    WHERE blogs.id != '$id'
    ORDER BY blogs.created_at DESC
    LIMIT 5");

if ($queryRecent && mysqli_num_rows($queryRecent) > 0) {
    $rowRecentBlog = mysqli_fetch_all($queryRecent, MYSQLI_ASSOC);
}
?>
<div class="container">
    <div class="row">

        <div class="col-lg-8">

            <!-- Blog Details Section -->
            <section id="blog-details" class="blog-details section">
                <div class="container">

                    <?php if ($blogDetail): ?>
                        <article class="article">

                            <div class="post-img">
                                <img width="100%" src="admin/uploads/<?php echo htmlspecialchars($blogDetail['image']) ?>" alt="" class="img-fluid">
                            </div>

                            <h2 class="title"><?php echo htmlspecialchars($blogDetail['title']) ?></h2>

                            <div class="meta-top">
                                <ul>
                                    <li class="d-flex align-items-center">
                                        <i class="bi bi-person"></i>
                                        <a href="#"><?php echo htmlspecialchars($blogDetail['penulis']) ?></a>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="bi bi-clock"></i>
                                        <a href="#">
                                            <time datetime="<?php echo htmlspecialchars($blogDetail['created_at']) ?>">
                                                <?php echo date("D m", strtotime($blogDetail['created_at'])) . "," . date("Y", strtotime($blogDetail['created_at'])) ?>
                                            </time>
                                        </a>
                                    </li>
                                </ul>
                            </div><!-- End meta top -->

                            <div class="content">
                                <?php echo $blogDetail['content'] ?>
                            </div><!-- End post content -->

                            <div class="meta-bottom">
                                <i class="bi bi-folder"></i>
                                <ul class="cats">
                                    <li><a href="#"><?php echo htmlspecialchars($blogDetail['name']) ?></a></li>
                                </ul>

                                <?php
                                $tags = json_decode($blogDetail['tags'], true);
                                if (is_array($tags) && !empty($tags)): ?>
                                    <i class="bi bi-tags"></i>
                                    <ul class="tags">
                                        <?php foreach ($tags as $tag): ?>
                                            <li><a href="<?php echo htmlspecialchars($tag['value']) ?>"><?php echo htmlspecialchars($tag['label'] ?? $tag['value']) ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div><!-- End meta bottom -->

                        </article>
                    <?php else: ?>
                        <p>Data blog tidak ditemukan.</p>
                    <?php endif; ?>

                </div>
            </section><!-- /Blog Details Section -->

        </div>

        <div class="col-lg-4 sidebar">

            <div class="widgets-container">

                <!-- Recent Posts Widget -->
                <div class="recent-posts-widget widget-item">

                    <h3 class="widget-title">Recent Posts</h3>
                    <?php if (!empty($rowRecentBlog)): ?>
                        <?php foreach ($rowRecentBlog as $recentBlog): ?>
                            <div class="post-item">
                                <h4>
                                    <a href="blog-detail.php?id=<?php echo $recentBlog['id'] ?>">
                                        <?php echo htmlspecialchars($recentBlog['title']) ?>
                                    </a>
                                </h4>
                                <time datetime="<?php echo htmlspecialchars($recentBlog['created_at']) ?>">
                                    <?php echo date("D m", strtotime($recentBlog['created_at'])) . "," . date("Y", strtotime($recentBlog['created_at'])) ?>
                                </time>
                            </div><!-- End recent post item-->
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Tidak ada posting terbaru.</p>
                    <?php endif; ?>
                </div><!--/Recent Posts Widget -->

                <!-- Tags Widget -->
                <div class="tags-widget widget-item">

                    <h3 class="widget-title">Tags</h3>
                    <ul>
                        <li><a href="#">App</a></li>
                        <li><a href="#">IT</a></li>
                        <li><a href="#">Business</a></li>
                        <li><a href="#">Mac</a></li>
                        <li><a href="#">Design</a></li>
                        <li><a href="#">Office</a></li>
                        <li><a href="#">Creative</a></li>
                        <li><a href="#">Studio</a></li>
                        <li><a href="#">Smart</a></li>
                        <li><a href="#">Tips</a></li>
                        <li><a href="#">Marketing</a></li>
                    </ul>

                </div><!--/Tags Widget -->

            </div>

        </div>

    </div>
</div>