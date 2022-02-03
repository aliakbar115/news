<aside class="sidebar">
    <section class="sidebar-item">
        <ul class="sidebar-list">
            <?php foreach ($categories as $category) { ?>

                <li>
                    <a href="<?= url('show-category/' . $category['id']); ?>">
                        <b>
                            <?php echo $category["name"]; ?>
                        </b>
                    </a>
                </li>

            <?php } ?>
        </ul>
    </section>
    <section class="sidebar-item">
        <h2 class="title">پست های محبوب</h2>

        <?php foreach ($sidebarPopularArticles as $article) { ?>

            <section class="popular-post">

                <img class="popular-post-img" src="<?= asset($article['image']); ?>" alt="">
                <section class="popular-post-title">
                    <h3>
                        <a href="<?= url('show-article/' . $article["id"]); ?>">
                            <b>
                                <?php echo $article["title"]; ?>
                            </b>
                        </a>
                    </h3>
                    <ul class="info-bar">
                        <li class="">
                            <span class="text-muted">by</span>
                            <a href="#" class="color-black">
                                <b>
                                    <?php echo $article["username"]; ?>
                                </b>
                            </a>
                            <span class="text-muted">
                                <?php echo date("Y m d", strtotime($article["created_at"])); ?>
                            </span>
                        </li>
                    </ul>
                </section>
                <section class="clear-fix"></section>
            </section>
        <?php } ?>
    </section>


</aside>
<!--end of sidebar-->