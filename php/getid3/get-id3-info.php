<?php
/**
 * Script to return ID3 info from MP3 tags
 * http://getid3.sourceforge.net
 *
 * @author Cormorant
 * @version 1.0
 * @package nomad2011
 **/

require_once('audioinfo.class.php');

if(!isset($_GET['file'])) die('No File');
// Get us the proper path to the file
$filename = $_GET['file'];
if(stripos($filename, '://')){
	$p_url = parse_url($filename);
	$filename = $p_url['path'];
}
$filename = $_SERVER['DOCUMENT_ROOT'] . $filename;

// Get MP3 Info
$au = new AudioInfo();
$info = $au->Info($filename);

//Output duration and filesize ready for JS
echo json_encode(array(
	'duration' => sec2hms($info['playing_time']),
	'filesize' => filesize($filename)
));

/* convert seconds to hh:mm:ss 
from: http://www.laughing-buddha.net/php/lib/sec2hms/
*/

function sec2hms ($sec, $padHours = false) 
{

 // start with a blank string
 $hms = "";
 
 // do the hours first: there are 3600 seconds in an hour, so if we divide
 // the total number of seconds by 3600 and throw away the remainder, we're
 // left with the number of hours in those seconds
 $hours = intval(intval($sec) / 3600); 

 // add hours to $hms (with a leading 0 if asked for)
 $hms .= ($padHours) 
       ? str_pad($hours, 2, "0", STR_PAD_LEFT). ":"
       : $hours. ":";
 
 // dividing the total seconds by 60 will give us the number of minutes
 // in total, but we're interested in *minutes past the hour* and to get
 // this, we have to divide by 60 again and then use the remainder
 $minutes = intval(($sec / 60) % 60); 

 // add minutes to $hms (with a leading 0 if needed)
 $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ":";

 // seconds past the minute are found by dividing the total number of seconds
 // by 60 and using the remainder
 $seconds = intval($sec % 60); 

 // add seconds to $hms (with a leading 0 if needed)
 $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);

 // done!
 return $hms;
 
}

?>
