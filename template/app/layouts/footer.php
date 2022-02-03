<footer class="footer">
    <section class="app bg-map">
        <section class="footer-row">
            <section class="footer-col">
                <img class="footer-logo" src="<?= asset($setting['logo']); ?>" alt="">
                <section class="clear-fix"></section>
                <p class="footer-p"><?php echo $setting['description']; ?></p>
                <p class="footer-p footer-p-margin-20">
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright 2021 All rights reserved | This template is made with <i class="ion-heart" aria-hidden="true"></i> by <a href="#" target="_blank">ali akbar</a>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </p>
            </section>
           
            <section class="footer-col">
                <h3 class="footer-section-title">پست محبوب</h3>
                <?php if (isset($popularArticles[0])) { ?>
                    <section class="footer-section-link-item">
                        <a href="#">
                            <?php echo $popularArticles[0]["title"] ?>
                        </a>
                        <p>
                            <?php echo date("Y m d", strtotime($popularArticles[0]["created_at"]))  ?>
                        </p>
                    </section>
                <?php  } ?>
                <?php if (isset($popularArticles[1])) { ?>
                    <section class="footer-line"></section>
                    <section class="footer-section-link-item">
                        <a href="#">
                            <?php echo $popularArticles[1]["title"] ?>
                        </a>
                        <p>
                            <?php echo date("Y m d", strtotime($popularArticles[1]["created_at"]))  ?>
                        </p>
                    </section>
                <?php  } ?>
            </section>

            <section class="footer-col">
                <h3 class="footer-section-title">پست محبوب</h3>
                <?php if (isset($popularArticles[2])) { ?>
                    <section class="footer-section-link-item">
                        <a href="#">
                            <?php echo $popularArticles[2]["title"] ?>
                        </a>
                        <p>
                            <?php echo date("Y m d", strtotime($popularArticles[2]["created_at"]))  ?>
                        </p>
                    </section>
                <?php  } ?>
                <?php if (isset($popularArticles[3])) { ?>
                    <section class="footer-line"></section>
                    <section class="footer-section-link-item">
                        <a href="#">
                            <?php echo $popularArticles[3]["title"] ?>
                        </a>
                        <p>
                            <?php echo date("Y m d", strtotime($popularArticles[3]["created_at"]))  ?>
                        </p>
                    </section>
                <?php  } ?>
            </section>

            <section class="clear-fix"></section>
        </section>
        <section class="footer-line"></section>
        <section class="footer-row">
            <ul class="footer-menu">
                <li><a href="">Terms & Conditions</a></li>
                <li><a href="">Privacy policy</a></li>
                <li><a href="">Jobs advertising</a></li>
                <li><a href="">Contact us</a></li>
            </ul>
            <ul class="footer-social-network">
                <li><a href=""><i class="fab fa-facebook"></i></a></li>
                <li><a href=""><i class="fab fa-twitter"></i></a></li>
                <li><a href=""><i class="fab fa-google-plus-g"></i></a></li>
                <li><a href=""><i class="fab fa-instagram"></i></a></li>
                <li><a href=""><i class="fab fa-bitcoin"></i></a></li>
            </ul>
            <section class="clear-fix"></section>
        </section>
    </section>
    <!--end of second app section-->
    <section class="clear-fix"></section>
</footer>
<!--end of footer-->

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>


<script type="text/javascript">
    
    function showMenu() {
        var x = document.getElementById("menu");
        if (x.className === "header-menu") {
            x.className += " show";
            console.log(1);
        } else {
            x.className = "header-menu";
            console.log(0);
        }
    }
</script>

</body>

</html>