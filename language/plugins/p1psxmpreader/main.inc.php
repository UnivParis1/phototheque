<?php
/*
Plugin Name: p1psxmpreader
Version: auto
Description: try to read some xmp metadata from our picture.
Plugin URI: auto
Author: Pascal
Author URI: http://www.pantheonsorbonne.fr
*/

defined('PHPWG_ROOT_PATH') or die('Hacking attempt!');


if (basename(dirname(__FILE__)) != 'p1psxmpreader')
{
  add_event_handler('init', 'p1psxmpreader_error');
  function p1psxmpreader_error()
  {
    global $page;
    $page['errors'][] = 'p1psxmpreader folder name is incorrect, uninstall the plugin and rename it to "p1psxmpreader"';
  }
  return;
}


add_event_handler(
  'format_exif_data',
  'xmptags_add_xmp_tags'
  );

  
function xmptags_add_xmp_tags($exif, $filename)
{
//	global $conf ;

	$xmp_array = conf_get_param('p1psxmp', array());
	
    // we don't provide all exif info, only want to add some
    if ($exif == null)
        return null;

    // code adapted from http://surniaulula.com/2013/04/09/read-adobe-xmp-xml-in-php/
    $max_size = 512000;
    $chunk_size = 65536;
    $start_tag = '<x:xmpmeta';
    $end_tag = '</x:xmpmeta>';
    $xmp_raw = null;
    $chunk = '';
    if ($file_fh = fopen( $filename, 'rb' ))
        {
        $file_size = filesize( $filename );
        while ( ( $file_pos = ftell( $file_fh ) ) < $file_size  && $file_pos < $max_size )
            {
            $chunk .= fread( $file_fh, $chunk_size );
            if ( ( $end_pos = strpos( $chunk, $end_tag ) ) !== false )
                {
                if ( ( $start_pos = strpos( $chunk, $start_tag ) ) !== false )
                    {
                    $xmp_raw = substr( $chunk, $start_pos, $end_pos - $start_pos + strlen( $end_tag ) );
                    }
                break;  // stop reading after finding the xmp data
                }
            }
        fclose( $file_fh );
        }
    if ($xmp_raw != null)
        {
			foreach($xmp_array as $exif_key => $regex)
			{
//        		$dcSubject = preg_match("/<dc:subject>\s*<rdf:(?:Bag|Seq)>\s*(.*?)\s*<\/rdf:(?:Bag|Seq)>\s*<\/dc:subject>/is", $xmp_raw, $match) ? $match[1] : null;
				$dcSubject = preg_match($regex, $xmp_raw, $match) ? $match[1] : null;
				if ($dcSubject != null)
				{
					$exif[$exif_key] = preg_match_all( "/<rdf:li[^>]*>([^>]*)<\/rdf:li>/is", $dcSubject, $match ) ? $match[1] : $dcSubject;
					if (is_array($exif[$exif_key]))
					$exif[$exif_key] = implode(',', $exif[$exif_key]);
				}
			}
        }
    return $exif;
}

