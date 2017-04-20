<?php
	/******************************************************************************************

		This example takes the following input images :
		- images/Hello.tif, a one-page TIFF that contains the word "Hello"
		/ images/multipage.tif, a 4-pages TIFF

		It generate an output file called 'merged.tif' which will have the following 
		contents :
		- Hello.tif (page 0)
		- multipage.tif (pages 1 to 4)
		- Hello.tif again (page 5)

		To properly run this example, you need two existing multipage tif files called
		'images/multipage.tif' and 'images/Hello.tif'.

		You can get the example images here :

		https://github.com/christian-vigh-phpclasses/TiffTools

	 ******************************************************************************************/

	require_once ( 'TiffMerger.phpclass' ) ;

	$output		=  'merged.tif' ;
	$file_1		=  'images/Hello.tif' ;
	$file_2		=  'images/multipage.tif' ;

	// Create an instance
	$merger		=  new TiffMerger ( ) ;

	// Add some files
	$merger -> Add ( $file_1, $file_2, $file_1 ) ;

	// Save the merged images to 'merged.tif'
	$merger -> SaveTo ( $output ) ;