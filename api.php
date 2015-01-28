<?php 
	
	// Include Worpress
	
	$wp_path = explode('wp-content', __FILE__ );
	require_once( $wp_path[0] . '/wp-load.php'); 

	status_header(200);

	$json = array();

	foreach( get_hb_blogs() as $blog ) 
	{

		switch_to_blog( $blog->blog_id );
		$xml_file = get_template_directory() . '/_template.xml';

		if ( ! file_exists( $xml_file ) ) continue; // ignore if no XML

		$xml = simplexml_load_file( $xml_file );


		$color = ( $xml->template->color ) ? $xml->template->color : "";
		

		if ( !empty($color ) ){

			$color = ', "color" : "'.$color.'"';

		}


		$json[] = array(
			'screen' => (string)$xml->template->screenshot,
			'category' => (string)$xml->template->tag,
			'buy'      => (string)$xml->template->buy,
			'href'     => site_url(),
			'color'    => (string)$color,
			'title'    => (string)$xml->template->title
		);
		

		restore_current_blog();
	}



	  $cachefile = "cached-api.html";


      $cachetime = 5 * 60; // 5 minutes


      // Serve from the cache if it is younger than $cachetime

      if (file_exists($cachefile) && (time() - $cachetime
         < filemtime($cachefile))) 
      {

         include($cachefile);


       
         exit;

      }

      ob_start(); // start the output buffer

  	echo " jsonCallback( ". json_encode($json) . ")";

   // open the cache file for writing
   $fp = fopen($cachefile, 'w'); 


   // save the contents of output buffer to the file
    fwrite($fp, ob_get_contents());

	// close the file

    fclose($fp); 

	// Send the output to the browser
    ob_end_flush(); 

