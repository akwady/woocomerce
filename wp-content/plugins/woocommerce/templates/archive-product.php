<?php get_header('shop'); ?>

<section id="archive-product-page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php

                defined('ABSPATH') || exit;

                do_action('woocommerce_before_main_content');

                ?>
                <header class="woocommerce-products-header">
                    <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
                        <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
                    <?php endif; ?>

                    <?php
                    /**
                     * Hook: woocommerce_archive_description.
                     *
                     * @hooked woocommerce_taxonomy_archive_description - 10
                     * @hooked woocommerce_product_archive_description - 10
                     */
                    do_action('woocommerce_archive_description');
                    ?>
                </header>
            </div>
            <div class="col-md-3">
                <?php get_template_part('sidebar-product') ?>
            </div>
            <div class="col-md-9 class-product">
                <?php
                if (woocommerce_product_loop()) {

                    do_action('woocommerce_before_shop_loop');

                    woocommerce_product_loop_start();

                    if (wc_get_loop_prop('total')) {
                        while (have_posts()) {
                            the_post();

                            do_action('woocommerce_shop_loop');

                            wc_get_template_part('content', 'product');
                        }
                    }

                    woocommerce_product_loop_end();

                    do_action('woocommerce_after_shop_loop');
                } else {
                    do_action('woocommerce_no_products_found');
                }
                ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer('shop'); ?>
