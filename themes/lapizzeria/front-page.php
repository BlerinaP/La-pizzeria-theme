<?php get_header();?>

<?php while(have_posts()): the_post(); ?>
    <div class="hero" style="background-image:url(<?php echo get_the_post_thumbnail_url(); ?>);">
        <div class="hero-content">
            <div class="hero-text">
                <h2><?php echo esc_html(get_option('blogdescription') ); ?></h2>
                <?php the_content(); ?>
                <?php $url = get_page_by_title('About Us'); ?>
                <a class="button secondary" href="<?php echo get_permalink($url->ID); ?>">more info</a>
            </div>
        </div>
    </div>
<?php endwhile; ?>

    <div class="main-content container">
        <main class="content-grid clear">
         <h2 class="primary-text text-center">Our Specialties</h2>
            <?php $args = array(
                'posts_per_page' => 3,
                'post_type' => 'specialties',
                'category_name' => 'pizzas',
                'orderby' =>'rand'
            );
            $specialties = new WP_Query($args);
            while($specialties->have_posts()): $specialties->the_post(); ?>
            <div class="secialty columns1-3">
                <div class="specialty-content">
                    <?php the_post_thumbnail('specialty_portrait'); ?>
                    <div class="information">
                        <h3><?php the_title(); ?></h3>
                        <?php the_content(); ?>
                        <p class="price">$ <?php the_field('price') ?></p>
                        <a href="<?php the_permalink(); ?>" class="button primary">read more</a>
                    </div>
                </div>
            </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </main>
    </div>

    <section class="ingridients">
            <div class="container">
                <div class="container-grid">
                   <?php while(have_posts()): the_post();?>
                    <div class="columns2-4">
                    <h3><?php the_field('ingredients_title');?></h3>
                        <?php the_field('ingredients_text');?>
                        <?php $url = get_page_by_title('About Us'); ?>
                        <a class="button primary"href="<?php echo get_permalink($url->ID); ?>">read more</a>
                    </div>
                    <div class="columns2-4 image">
                        <img src="<?php the_field('ingredients_image');?>" alt="Fresh Ingredients">
                    </div>
                  <?php endwhile; ?>
                </div>
            </div>
    </section>

    <section class="container clear">
        <h2 class="primary-text text-center">Gallery</h2>
        <?php
         $url = get_page_by_title('Gallery');
         echo get_post_gallery($url->ID)
        ?>
    </section>

    <section class="location-reservation clear container">
        <div class="container-grid">
            <div class="columns2-4">
                <div id="map">
                    map is here
                </div>
            </div>
                <div class="columns2-4">
                    <?php get_template_part('templates/reservation'); ?>
                </div>
        </div>
    </section>

    <style>
        #map{
            height: 400px;
        }
    </style>
    <?php $apikey = esc_html(get_option('lapizzeria_gmap_apikey'));?>
    <script src="https://maps.googleapis.com/maps/api/js?key . $apikey . =&callback=initMap"
            async defer></script>

<?php get_footer();?>