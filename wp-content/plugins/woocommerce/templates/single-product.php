<?php get_header( 'shop' ); ?>



	<section id="single-product">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
                    <?php
                    if ( ! defined( 'ABSPATH' ) ) {
                        exit;
                    }
                    do_action( 'woocommerce_before_main_content' );

                    while ( have_posts() ) : the_post();

                        wc_get_template_part( 'content', 'single-product' );

                    endwhile;
                    do_action( 'woocommerce_after_main_content' );
                    ?>
				</div>
			</div>
		</div>
	</section>



<?php get_footer( 'shop' );?>

