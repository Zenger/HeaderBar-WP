<?php 

	// Include Worpress

	/* define('HBWP_PATH', reset(explode('wp-content', __FILE__ )));

	require_once(HBWP_PATH . '/wp-blog-header.php'); */





	define('HB_URL', plugins_url() . "/" . basename(dirname(__FILE__)) );



	function get_hburl() {

		echo HB_URL;

	}

	

	function get_hb_blogs() {

		global $wpdb;

		$blogs = $wpdb->get_results("SELECT blog_id,domain,path FROM ms_t_blogs WHERE public = 1 AND blog_id <> 1 ORDER BY blog_id DESC");

		return $blogs;

	}

	

	function hb_get_template_name_by_blog_id( $blog_id )

	{

		global $wpdb;

		$template = $wpdb->get_row("SELECT option_value FROM ms_t_".$blog_id."_options WHERE option_name = 'template'" );

		

		return $template->option_value;

	}

	



if (!is_admin()) {





	if (isset($_GET['iframe'])) {

		if ($_GET['iframe'] == true)	{
			

		

	
		$xml =  simplexml_load_file( get_template_directory() . '/_template.xml' );
		

		@$current = (object) array(

			'url' => site_url(), 

			'buy' =>  $xml->template->buy,

			'title' => $xml->template->title

		);

	
		

		



?>

	<!DOCTYPE HTML>

	<html lang="en-US">

	<head>

		<meta charset="UTF-8">

		<title>Welcome to 1theme.com</title>

		<link rel="stylesheet" href="<?php get_hburl(); ?>/css/style.css">

		<script type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/jquery/jquery.js"></script>

		<script type="text/javascript" src="<?php get_hburl(); ?>/js/bar.js"></script>

	</head>

	<body>

	

		<div id="bar_1theme">

			<div class="bar_1theme_inside">

				<a href="http://1theme.com/" id="logo_1theme"><img src="<?php echo get_hburl(); ?>/images/logo.png" width="99" height="39" alt="" /></a>

				<span id="slogan">&nbsp;</span>

				

				<div class="dropdown_1theme">

					<div class="list_1theme">

						<span class="active_item"><?php bloginfo('title'); ?></span>

						<ul class="themes_list">

							

							<?php 

								

								foreach( get_hb_blogs() as $blog ) 

								{
									if ($blog->blog_id == 2) continue;
									//print_r($blog);

									switch_to_blog( $blog->blog_id );

									$xml_file = get_template_directory() . '/_template.xml';



									

									if ( ! file_exists( $xml_file ) ) continue; // ignore if no XML

									

									$xml = simplexml_load_file( $xml_file );

									

									$color = ( $xml->template->color ) ? $xml->template->color : "";

									

									if ( !empty($color ) ){

										$color = ', "color" : "'.$color.'"';

									}

									?>

									

									

									<li>

									<a href="#" data-1theme-info='{"screen" : "<?php echo $xml->template->screenshot;  ?>", "category" : "<?php echo $xml->template->tag; ?>", "buy": "<?php echo $xml->template->buy; ?>", "href": "<?php echo site_url(); ?>" <?php echo $color; ?> }'> <?php echo $xml->template->title; ?></a>

									</li>

									<?php

								}

								

								restore_current_blog(); // reset current blog

							?>

							

						

						</ul>

					</div>

					<a href="http://1theme.com/subscribe/" class="subscribe_1theme">&nbsp;</a>

					<div class="clear"></div>

				</div>

				

				<div class="purchase_close_1theme">

					<a href="<?php echo $current->buy; ?>" class="purchase_1theme">&nbsp;</a>

					<a href="<?php echo $current->url; ?>" class="close_1theme">&nbsp;</a>

				</div>

			</div>

		</div>

	

	

		



		<iframe width="100%" height="100%" frameborder="0" src="<?php echo $current->url; ?>" id="frame"></iframe>

	</body>

	</html>



<?php die(); ?>

 <?php
 		}
	}

} 