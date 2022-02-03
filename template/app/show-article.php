<?php

require_once(BASE_PATH . "/template/app/layouts/head-tag.php");
?>
<section class="content">

    <section class="container">
        <main class="main">
            <section class="main-news">
                <h2 class="title">
                    <?php echo $article["title"] ?>
                </h2>
                <article>
                    
                    <img class="main-news-img" src="<?= asset($article['image']); ?>" alt="">
                    <h3 class="article-title">
                        <a href="<?= url('show-article/' . $article['id']) ?>">
                            <?php echo $article["title"] ?>
                        </a>
                    </h3>
                    <ul class="info-bar">
                        <li class="">
                            <span class="text-muted">by</span>
                            <a href="#" class="color-black">
                                <b>
                                    <?php echo $username["username"] ?>
                                </b>
                            </a>
                            <span class="text-muted"> <?php echo date("Y m d", strtotime($article["created_at"]))  ?></span>
                        </li>
                        <li><i class="fas fa-bolt text-yellow"></i> <?php echo $article["view"] ?></li>
                        <li><i class="fas fa-comments text-yellow"></i> <?php echo $commentsCount["COUNT(*)"] ?></li>
                    </ul>
                    <p><?php echo $article["summary"] ?></p>

                    <p class="footer-p-margin-20"><?php echo $article["body"] ?></p>

                </article>

                <?php foreach ($comments as $comment) { ?>


                    <section class="comment-box">
                        <h3 class="comment-box-header">
                            <?php echo $comment["username"] ?>
                            <span class="comment-box-date"><?php echo date("Y m d", strtotime($comment["created_at"]))  ?></span>
                        </h3>
                        <comment>
                            <?php echo $comment["comment"] ?>
                        </comment>
                    </section>
                <?php } ?>
                <?php if (isset($_SESSION["user"])) { ?>
                    <!-- تنها کسی که لاگین کرده میتونه کامنت بگزارد -->
                    <form action="<?= url('comment-store') ?>" method="post">
                        <input name="article_id" type="hidden" value="<?php echo $article["id"] ?>">
                        <textarea class="comment" name="comment" rows="4" required placeholder="your comment ..."></textarea>
                        <input class="submit" type="submit" value="store comment">
                    </form>
                <?php } ?>
            </section>
            <!--end of main news-->


        </main>
        <!--end of main-->


        <?php
        require_once(BASE_PATH . "/template/app/layouts/sidebar.php");
        ?>


        <section class="clear-fix"></section>
    </section>
    <!--end of container-->
</section>
<!--end of content-->
</section>
<!--end of first app section-->



<?php
require_once(BASE_PATH . "/template/app/layouts/footer.php");
?>