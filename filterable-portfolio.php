

add_filter( 'body_class', 'filerable_portfolio_add_body_class' );
//* Filterable Portfolio custom body class
function filerable_portfolio_add_body_class( $classes ) {
$classes[] = 'filterable-portfolio-page';
return $classes;
}
/**
* Outputs a custom loop
*
* @global mixed $paged current page number if paginated
* @return void
*/
function filterable_portfolio_do_loop() { ?>
 
<header id="page-heading" class="entry-header">
<?php 
$args = array('include'  => array(28,29,30,31,32,33));
     
 $terms = get_terms( 'category', $args );

 ?>
<?php if( $terms[0] ) { ?>
<ul id="portfolio-cats" class="filter clearfix">
<li><a href="#" class="active" data-filter="*"><span><?php _e('All', 'genesis'); ?></span></a></li>
<?php foreach ($terms as $term ) : ?>
<li><a href="#" data-filter=".<?php echo $term->slug; ?>"><span><?php echo $term->name; ?></span></a></li>
<?php endforeach; ?>
</ul><!-- /portfolio-cats -->
<?php } ?>
</header><!-- /page-heading -->
 
<div class="entry-content" itemprop="text">
<?php 
//$event1 = current_time('Ymd');
$wpex_port_query = new WP_Query(
array(
          'tax_query' => array(
    array(
        'taxonomy' => 'soort-bijdrage',
        'terms' => 'evenementen',
        'field' => 'slug',
    )),
'showposts' => '-1',
'no_found_rows' => true,
 'meta_query' => array(
        array(
            'key' => 'datum',
            //'compare' => '>=',
            ///'value' => $event1,
            )
            ),
    'meta_key' => 'datum',
    'orderby' => 'meta_value',
    'order' => 'ASC',
)
);
if( $wpex_port_query->posts ) { ?>
<div id="portfolio-wrap" class="clearfix filterable-portfolio">
<div class="portfolio-content">
<?php $wpex_count=0; ?>
<?php while ( $wpex_port_query->have_posts() ) : $wpex_port_query->the_post(); ?>
<?php $wpex_count++; ?>
<?php $terms = get_the_terms( get_the_ID(), 'category' ); 
 $date = DateTime::createFromFormat('Ymd', get_field('datum')); ?>
<?php if ( has_post_thumbnail($post->ID) ) { ?>
<article class="portfolio-item col-<?php echo $wpex_count; ?> <?php if( $terms ) foreach ( $terms as $term ) { echo $term->slug .' '; }; ?>">
<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php echo genesis_get_image( array( size => 'portfolio' ) ); ?>
<div class="portfolio-overlay"><h3><?php the_title(); ?>  <?php   echo $date->format('d-m-y'); ?></h3></div><!-- portfolio-overlay --></a>
</article>
<?php } ?>
<?php endwhile; ?>
</div><!-- /portfolio-content -->
</div><!-- /portfolio-wrap -->
<?php } ?>
<?php wp_reset_postdata(); ?>
</div><!-- /entry-content -->
 
<?php }
genesis(); 