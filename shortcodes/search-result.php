<?php

$site_url = get_site_url();

if(isset($_GET['s']) == "property"){
}

if(isset($_GET['property_type'])){
    $property_type = $_GET['property_type'];
}
if(isset( $_GET['state'])){
    $state = $_GET['state'];
}
if(isset($_GET['city'])){
    $city = $_GET['city'];
}
if(isset($_GET['bed'])){
    $bedroom = $_GET['bed'];
}
if(isset($_GET['bathroom'])){
    $bathroom = $_GET['bathroom']; 
}
if(isset($_GET['min'])){
    $min_price = $_GET['min']; 
}
if(isset($_GET['max'])){
    $max_price = $_GET['max']; 
}



$args = array(
    'post_type' => 'property',
    'meta_query' => array(
        'relation'      => 'AND',
        ),

);

if(isset($property_type) && $property_type) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'property_type',
            'field' => 'id',
            'terms' => $property_type,
        ),
    );
}

if(isset($state) && $state) {
    $args['meta_query'][] = [
        'key' => 'select_your_state',
        'value' =>  $state,
        'compare' => '=',
    ];
}

if(isset($city) && $city) {
    $args['meta_query'][] = [
        'key' => 'select_your_city',
        'value' =>  $city,
        'compare' => '=',
    ];
}

if(isset($bedroom) && $bedroom) {
    $args['meta_query'][] = [
        'key' => 'bedroom',
        'value' =>  $bedroom ,
        'type'      => 'NUMERIC',
        'compare' => '=',
    ];
}

if(isset($bathroom) && $bathroom) {
    $args['meta_query'][] =         [
        'key' => 'bathroom',
        'value' =>  $bathroom,
        'type'      => 'NUMERIC',
        'compare' => '=',
    ];
}

if(isset($min_price) && $min_price && isset($max_price) && $max_price) {
    $args['meta_query'][] =  [
        'key' => 'price',
        'value' => array( $min_price, $max_price ),
        'type'      => 'NUMERIC',
        'compare' => 'BETWEEN',
    ];
}elseif(isset($min_price) && $min_price){
	    $args['meta_query'][] =  [
        'key' => 'price',
        'value' => $min_price,
        'type'      => 'NUMERIC',
        'compare' => '>=',
    ];
}elseif(isset($max_price) && $max_price){
	    $args['meta_query'][] =  [
        'key' => 'price',
        'value' => $max_price,
        'type'      => 'NUMERIC',
        'compare' => '<=',
    ];
}

// print_r("<pre>");
// print_r($args['meta_query']);
// die();

$search_results = new WP_Query( $args );
// if($search_results->found_posts > 0){
//     echo "ok";
//     }else{
//         echo "err";
//     }

?>


<div class="cc-container dgt-search-ele">
<section class="property">
  <div class="container-fluid">
    <div class="row">

    <?php
    
   
            if ( $search_results->have_posts() ) {
                while($search_results->have_posts()) : $search_results->the_post();
			  
                    $post_id = get_the_ID();
    		        $post_link = get_permalink();
                    $post_title = get_the_title();
                    $price = get_field('price');
                    $bedroom = get_field('bedroom');
                    $bathroom = get_field('bathroom');
                    $square_fit = get_field('square_fit');
                    $location = get_field('location');
                    $gallery = get_field('gallery');
                    $terms = get_the_terms( get_the_ID() , 'property_type' );
                    foreach ( $terms as $term ) {
                        $category_name =  $term->name;
                    }
                     

    ?>

      <div class="col-md-4">
        <div class="card  property-id-<?php echo $post_id;?>">
          <div class="card-header">
            <h3><?php echo $category_name; ?></h3>
          </div>
         <div class="property-img">
            <a class="view-btn" href="<?php echo $post_link; ?>">View</a>
          <img src='<?php the_post_thumbnail_url(); ?>' alt=''>
         </div>
          <div class="fearures">
            <div class="fearures-content">
              <img src="<?php echo $site_url;?>/wp-content/uploads/2023/03/sqft1.svg" alt="">
              <p><?php echo $square_fit; ?> sq ft </p>
            </div>
            <div class="fearures-content">
              <img src="<?php echo $site_url;?>/wp-content/uploads/2023/03/bedroom.svg" alt="">
              <p><?php echo $bedroom; ?> Bedrooms</p>
            </div>
            <div class="fearures-content">
                <img src="<?php echo $site_url;?>/wp-content/uploads/2023/03/bathroom.svg" alt="">
                <p><?php echo $bathroom; ?> Bathrooms</p>
            </div>
          </div>
          <div class="card-body">
            <h4><?php echo $post_title; ?></h4>
            <h5><i aria-hidden="true" class="fas fa-map-marker-alt"></i> <?php echo $location; ?></h5>
            <p><?php 
            $excerpt = get_the_excerpt(); 
            $excerpt = substr( $excerpt, 0, 200 );
            $result = substr( $excerpt, 0, strrpos( $excerpt, ' ' ) );
            echo $result;
            ?> </p>
          </div>
          <div class="card-footer">
            <div class="col-md-8 price-box">
              <p>$<?php echo $price; ?></p>
            </div>

            <div class="col-md-4 box-icon-list">
            <div class="gallery-box">
              <img src="<?php echo $site_url;?>/wp-content/uploads/2023/03/gallerys.svg" alt="">
              <span> <?php echo count($gallery);?></span>
            </div>
            <div class="video-box">
              <img src="<?php echo $site_url;?>/wp-content/uploads/2023/03/video-icon.svg" alt="">
            </div>
            </div>
          </div>

        </div>
      </div>

    <?php
        endwhile;
        wp_reset_postdata();
    } else {
        echo "<h2 class='not-found'>No Property Found! </h2>";
    }
    ?>


    </div>
  </div>
</section>
</div>
