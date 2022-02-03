<?php
    require_once(BASE_PATH . "/template/admin/layouts/head-tag.php");
?>

<section class="pt-3 pb-1 mb-2 border-bottom">
    <h1 class="h5">Create Menu</h1>
</section>

<section class="row my-3">
    <section class="col-12">
        <form method="post" action="<?= url('menu/store') ?>">
            <div class="form-group">
                <label for="name">name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name ..." required>
            </div>

            <div class="form-group">
                <label for="url">url</label>
                <input type="text" class="form-control" id="url" name="url" placeholder="Enter url ..." required>
            </div>

            <div class="form-group">
                <label for="parent_id">parent ID</label>

                <select name="parent_id" id="parent_id" class="form-control" autofocus>
                    <option value="">root</option>
                    <!--به معنی منو اصلی است و در سیستم منو اصلی ثبت می شد root-->
                    <?php foreach ($menus as $menu) { ?>
                        <!-- فقط منو اصلی نمایش داده می شود چون به این صورت تعریف کرده بودیم  -->
                        <option value="<?php echo $menu["id"]; ?>"><?php echo $menu["name"]; ?></option>

                    <?php } ?>

                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-sm">store</button>
        </form>
    </section>
</section>
<?php
    require_once(BASE_PATH . "/template/admin/layouts/footer.php");
?>