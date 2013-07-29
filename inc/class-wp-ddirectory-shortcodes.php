<?php
/**
 * Shortcodes
 *
 * Adds shortcodes for various important displays.
 */

class WP_Downloads_Directory_Shortcodes {

	public function __construct() {

		// Add jobs listing shortcode
		add_shortcode( 'wpddir_downloads_list', array( $this, 'downloads_listing' ) );

	}

	public function downloads_listing( $atts ) {

		ob_start();

		// Extract the attributes in the shortcode to own variables
		extract( shortcode_atts( array(
			'amount'       => -1,
			'orderby'      => 'date',
			'order'        => 'desc',
		), $atts ) );

		// Query Arguments
		$downloads_query_args = array(
			'post_type'           => 'wpddir_downloads',
			'posts_per_page'      => $amount,
			'orderby'             => $orderby,
			'order'               => $order,
			'ignore_sticky_posts' => 1,
			'meta_query' 			 => array(
				array(
					'key'     => 'wpddir_hide',
					'value'   => 1,
					'compare' => '!=',
				),
			),
		);

		$downloads_query = new WP_Query( $downloads_query_args );

		if ( $downloads_query->have_posts() ) : ?>

			<ul>

				<?php while ( $downloads_query->have_posts() ) : $downloads_query->the_post(); ?>

					<li>
						<ul>
							<li class="downloads-thumbnail">
								<?php the_post_thumbnail(); ?>
							</li>
							<li class="downloads-info">
								<h3 class="downloads-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<div class="downloads-excerpt"><?php echo get_post_meta( get_the_ID(), 'wpddir_excerpt', true ); ?></div>
								<div class="downloads-price"><span class="price"><?php echo get_post_meta( get_the_ID(), 'wpddir_price', true ); ?></span></div>
								<div class="downloads-actions">
									<a href="<?php echo get_post_meta( get_the_ID(), 'wpddir_ejunkie_link', true ); ?>" class="button large"><?php _e('Direct Download', 'wpddirectory'); ?></a>
									<a href="<?php the_permalink(); ?>" class="button large"><?php _e('More info', 'wpddirectory'); ?></a>
								</div>
							</li>
						</ul>
					</li>

				<?php endwhile; ?>

			</ul>

		<?php else : ?>

			<p><?php _e('We could not find any downloads to show.', 'wpddirectory'); ?></p>

		<?php endif;

		wp_reset_postdata();

		return '<div class="downloads-listing">' . ob_get_clean() . '</div>';

	}

}

new WP_Downloads_Directory_Shortcodes();