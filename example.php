<?php
	/******************************************************************************************

		This example takes a multipage TIFF file (example.tif) and extracts all its
		pages to example.1.tif up to example.x.tif.

		To properly run this example, you need an existing multipage tif file called
		'example.tif' 

	 ******************************************************************************************/

	require_once ( 'TiffSplitter.phpclass' ) ;

	$tiff		=  TiffSplitter::Load ( 'example.tif' ) ;

	foreach ( $tiff  as  $page )
	   {
		$output		=  'page.' . $page -> PageNumber . '.tif' ;
		$page -> SaveTo ( $output ) ;
	    }