<?php
	/******************************************************************************************

		This example takes a multipage TIFF file (example.tif) and extracts all its
		pages to page.0.tif up to page.x.tif.

		To properly run this example, you need an existing multipage tif file called
		'images/multipage.tif'.

		You can get the example images here :

		https://github.com/christian-vigh-phpclasses/TiffTools

	 ******************************************************************************************/

	require_once ( 'TiffSplitter.phpclass' ) ;

	$tiff		=  TiffSplitter::Load ( 'images/multipage.tif' ) ;

	foreach ( $tiff  as  $page )
	   {
		$output		=  'page.' . $page -> PageNumber . '.tif' ;
		$page -> SaveTo ( $output ) ;
	    }