# INTRODUCTION #

The **TiffSplitter** class takes a multi-page TIFF file and splits it into separate TIFF files containing one image at a time.

It can operate on files that are larger than the available memory, or simply on strings containing TIFF data already loaded into memory from an existing TIFF file (or generated on-the-fly).

Using it is fairly simple : 

	include ( 'TiffSplitter.phpclass' ) ;

	$tiff 	=  TiffSplitter::Load ( 'sample.tif' ) ;

(note that you won't instantiate a **TiffSplitter** object directly : you will have to call either the *Load()* or *LoadFromString()* methods to do that).

Once an instance has been created, you can use the array access or iterator methods to loop through each page of your input file :

	 
	for ( $i = 0 ; $i  <  count ( $tiff ) ; $i ++ )
	   {
			$tiff_page 		=  $tiff [$i] ;
			... do something with $tiff_page ...
	    }

or :

	foreach  ( $tiff  as  $tiff_page )
	   {
			... do something with $tiff_page ...
	    }

Each TIFF page, of type **TiffSplitterPage** contained in a **TiffSplitter** object has two interesting methods :

- *AsString()*, which returns TIFF data for the current page directly as a string
- *SaveTo()*, which saves the current page to the specified file.

So, a basic example to save multi-page TIFF files as single-page ones would be :

	include ( 'TiffSplitter.phpclass' ) ;

	$tiff 	=  TiffSplitter::Load ( 'sample.tif' ) ;

	foreach  ( $tiff  as  $tiff_page )
	   {
			$tiff_page -> SaveTo ( "sample.page.{$tiff_page -> PageNumber}.tif" ) ;
	    }

# KNOWN LIMITATIONS AND ISSUES #

The **TiffSplitter** class currently has the following limitations :

- It cannot directly generate PDF files. This is planned for a future release
- Some TIFF files created with Adobe Photoshop cannot be decoded properly. I still have to understand how Adobe interprets the TIFF specifications
- The EXIF information will not be included in the output file(s)

# DOCUMENTATION REFERENCES #

The following links provide useful information about the TIFF file format :

- [https://www.itu.int/itudoc/itu-t/com16/tiff-fx/docs/tiff6.pdf](https://www.itu.int/itudoc/itu-t/com16/tiff-fx/docs/tiff6.pdf "https://www.itu.int/itudoc/itu-t/com16/tiff-fx/docs/tiff6.pdf") : TIFF V6 format specification
- [http://www.awaresystems.be/imaging/tiff.html](http://www.awaresystems.be/imaging/tiff.html "http://www.awaresystems.be/imaging/tiff.html") : really useful information and reference about the TIFF file format


# CLASS REFERENCE #

## TiffSplitter class ##

The **TiffSplitter** class is used to open a multi-page TIFF file and provides a way to save each image into separate output TIFF files.

The **TiffSplitter** class cannot be instantiated directly : you have to use the *Load()* or *LoadFromString()* method instead.

The **TiffSplitter** class inherits from **TiffImage**, which primiraly defines some constants.

### Methods ###

#### Load ####

	$tiff 	=  TiffSplitter::Load ( $filename, $buffer_size = 8192, $cache_size = 512 )

Creates an instance of the **TiffSplitter** class and loads from the specified file primary information about its contents. This mainly concerns Image File Directory (IFD) information.

Only the necessary parts of the specified file are loaded into memory, the rest of the file being cached on demand. Two parameters affect this behavior :

- *$buffer\_size* : Size of a cache buffer. The default value of 8192 should be enough in most cases.
- *$cache\_size* : Maximum number of buffers in the cache. The default values for *$buffer\_size* and *$cache\_size* has been designed to allow for a cache of up to 4Mb.

Caching information is the best way to handle files that are greater than the size specified by your *memory\_limit* PHP setting. Smaller cache sizes will mean more disk accesses, greater cache sizes will consume more memory. It's up to you to chose the right balance, depending on your processing needs.

Note that greater buffer sizes will not necessarily improve performance. A size of 8Kb is in a mjority of case well suited for Linux systems.

#### LoadFromString ####

	$tiff 	=  TiffSplitter::LoadFromString ( $tiff_data ) ;

Creates a **TiffSplitter** instance from the specified string, which can contain TIFF data loaded either from an existing TIFF file, or generated on-the-fly.

Note that no caching mechanism will apply in this case.


### Properties ###

#### $DEBUG (boolean) ####

Setting this static property to *true* will show information about the internal structure of the TIFF file.

#### Endianness ####

Specifies the endianness (byte order) of the supplied TIFF data ; it can take the following values :

- *TiffImage::LITTLE\_ENDIAN* : Multiple byte values are stored with the least significant byte first.
- *TiffImage::BIG\_ENDIAN* : Multiple byte values are stored with the most significant byte first.

You cannot change the endianness of the generated output TIFF files. This property is informational only.

#### $Filename (string) ####

Input filename. This property will be set to *false* if the object has been created with the *LoadFromString()* method.


## TiffSplitterPage class ##

This class encapsulates one single page from the supplied multi-page TIFF file. It inherits from the **TiffPage** class (which is not documented here). It provides the following :

### Methods ###

#### AsString ####

	$data 		=  $tiff_page -> AsString ( $format = TiffImage::OUTPUT_FORMAT_TIFF ) ;

Returns TIFF data corresponding to the page. This data can be directly saved on disk.

The *$format* parameter can have one of the following values :

- *TiffImage::OUTPUT_FORMAT_TIFF* : Generates a TIFF file.
- *TiffImage::OUTPUT_FORMAT_PDF* : Generates a PDF file (not yet implemented).

#### SaveTo ####

	$tiff_page -> SaveTo ( $filename, $format = TiffImage::OUTPUT_FORMAT_TIFF ) ;

Saves the page to the specified file.


### Properties ###

#### PageHeight ####

Page height in lines.


#### PageNumber ####

Corresponding page number. Starts from zero most of the time.


#### PageWidth ####

Page width in pixels.


