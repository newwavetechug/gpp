<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 5/2/14
 * Time: 4:57 PM
 *
 * i cant begin to stress how important these functions are
 */

//generate seo friendly funtions
function seo_url($string)
{
    //Lower case everything
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return strtolower($string);
}

//limit strings to only the first 100

function limit_words($string,$word_count)
{
    if (strlen($string) > $word_count) {

        // truncate string
        $stringCut = substr($string, 0, $word_count);

        // make sure it ends in a word so assassinate doesn't become ass...
        $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'';
    }
    return $string;
}


//remove dashes between words
function remove_dashes($string)
{
   return str_replace('-', ' ', $string);

}

//validate emails
function validate_mail($email)
{

    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        return FALSE;
    }
    else
    {
       return TRUE;
    }
}

//get all files in a directory randomly
function get_all_directory_files($directory_path)
{

    $scanned_directory = array_diff(scandir($directory_path), array('..', '.'));



    return custom_shuffle($scanned_directory);
}

//to shuffle the elements
function custom_shuffle($my_array = array()) {
    $copy = array();
    while (count($my_array)) {
        // takes a rand array elements by its key
        $element = array_rand($my_array);
        // assign the array and its value to an another array
        $copy[$element] = $my_array[$element];
        //delete the element from source array
        unset($my_array[$element]);
    }
    return $copy;
}



//to clear forrm fields
function clear_form_fields()
{
    $str='';
    $str.='<script>
							  $(".form-horizontal")[0].reset();
							  </script>';
    return $str;
}





//check if ur on localhost
function check_localhost()
{
    if ( $_SERVER["SERVER_ADDR"] == '127.0.0.1' )
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

//get real ip address
function get_real_ip_address()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}



//remove underscors from a string
function remove_underscore($string)
{
    return str_replace('_', ' ', $string);
}



function last_segment()
{
    $ci=& get_instance();
    $last = $ci->uri->total_segments();
    return $ci->uri->segment($last);
}

function strtotitle($title)
// Converts $title to Title Case, and returns the result.
{
// Our array of 'small words' which shouldn't be capitalised if
// they aren't the first word. Add your own words to taste.
    $smallwordsarray = array(
        'of','a','the','and','an','or','nor','but','is','if','then','else','when',
        'at','from','by','on','off','for','in','out','over','to','into','with'
    );

// Split the string into separate words
    $words = explode(' ', $title);

    foreach ($words as $key => $word)
    {
// If this word is the first, or it's not one of our small words, capitalise it
// with ucwords().
        if ($key == 0 or !in_array($word, $smallwordsarray))
            $words[$key] = ucwords($word);
    }

// Join the words back into a string
    $newtitle = implode(' ', $words);

    return $newtitle;
}

function jquery_redirect($url)
{
    ?>
    <script>
        // similar behavior as an HTTP redirect
        window.location.replace("<?=$url?>");

        var delay = 1000; //Your delay in milliseconds

        setTimeout(function(){ window.location = URL; }, delay);
    </script>
<?php
}



//print an array
function print_array($array) {
    print '<pre>';
    print_r($array);
    print '</pre>';
}


function jquery_clear_fields()
{
    ?>
    <script>
        $(".form-horizontal")[0].reset();
        $(".form")[0].reset();
    </script>
<?php
}

function jquery_alert($alert_message)
{
    ?>
    <script>
        // similar behavior as an HTTP redirect
        alert('<?=$alert_message?>')
    </script>
<?php
}


function check_live_server()
{
    $whitelist = array(
        '127.0.0.1',
        '::1'
    );

    if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist))
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}



function video_image($url){
    $image_url = parse_url($url);
    if($image_url['host'] == 'www.youtube.com' ||
        $image_url['host'] == 'youtube.com'){
        $array = explode("&", $image_url['query']);
        return "http://img.youtube.com/vi/".substr($array[0], 2)."/0.jpg";
    }else if($image_url['host'] == 'www.youtu.be' ||
        $image_url['host'] == 'youtu.be'){
        $array = explode("/", $image_url['path']);
        return "http://img.youtube.com/vi/".$array[1]."/0.jpg";
    }else if($image_url['host'] == 'www.vimeo.com' ||
        $image_url['host'] == 'vimeo.com'){
        $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/".
            substr($image_url['path'], 1).".php"));
        return $hash[0]["thumbnail_medium"];
    }
}

function age_from_dob($dob){
    $dob = strtotime($dob);
    $y = date('Y', $dob);
    if (($m = (date('m') - date('m', $dob))) < 0) {
        $y++;
    } elseif ($m == 0 && date('d') - date('d', $dob) < 0) {
        $y++;
    }
    return date('Y') - $y;
}


//function to get thumbnail from photo_name
function get_thumbnail($image_name)
{
    $pieces=explode('.',$image_name);

    return $pieces[0].'_thumb.'.$pieces[1];
}

function make_unique_id()
{
    return uniqid();
}

function send_mail($to,$subject,$message,$from)
{
    $to = $to;
    $subject = $subject;
    $body = $message;
    $headers = "From: ".$from."\r\n";
    $headers .= "Reply-To: ".$from."\r\n";
    $headers .= "Return-Path: ".$from."\r\n";
    $headers .= "X-Mailer: PHP5\n";
    $headers .= 'MIME-Version: 1.0' . "\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    if(check_live_server()==TRUE)
    {
        if(mail($to,$subject,$body,$headers))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    else
    {
        return FALSE;
    }

}

function unzip_file($location,$newLocation)
{
    if(exec("unzip $location",$arr)){
        mkdir($newLocation);
        for($i = 1;$i< count($arr);$i++){
            $file = trim(preg_replace("~inflating: ~","",$arr[$i]));
            copy($location.'/'.$file,$newLocation.'/'.$file);
            unlink($location.'/'.$file);
        }
        return TRUE;
    }else{
        return FALSE;
    }
}

function csv_to_array($myString)
{
    return explode(',', $myString);
}

function jquery_redirect_with_delay($url,$delay_milliseconds)
{
    ?>
    <script>
        var delay = '<?=$delay_milliseconds?>'; //Your delay in milliseconds

        setTimeout(function(){ window.location = '<?=$url?>'; }, delay);
    </script>
<?php
}

function get_user_country($ip_address)
{
    if (check_live_server()) {
        //enable soap for this to work
        $client = new SoapClient("http://www.webservicex.net/geoipservice.asmx?WSDL");
        $params = new stdClass;
        $params->IPAddress = $ip_address;
        $result = $client->GetGeoIP($params);
        // Check for errors...
        return $result->GetGeoIPResult->CountryName;
    }



}


//Get an array with geoip-infodata
function get_geo_info($ip)
{
    //check, if the provided ip is valid
    if(!filter_var($ip, FILTER_VALIDATE_IP))
    {
        throw new InvalidArgumentException("IP is not valid");
    }

    //contact ip-server
    $response=@file_get_contents('http://www.netip.de/search?query='.$ip);
    if (empty($response))
    {
        throw new InvalidArgumentException("Error contacting Geo-IP-Server");
    }

    //Array containing all regex-patterns necessary to extract ip-geoinfo from page
    $patterns=array();
    $patterns["domain"] = '#Domain: (.*?)&nbsp;#i';
    $patterns["country"] = '#Country: (.*?)&nbsp;#i';
    $patterns["state"] = '#State/Region: (.*?)<br#i';
    $patterns["town"] = '#City: (.*?)<br#i';

    //Array where results will be stored
    $ipInfo=array();

    //check response from ipserver for above patterns
    foreach ($patterns as $key => $pattern)
    {
        //store the result in array
        $ipInfo[$key] = preg_match($pattern,$response,$value) && !empty($value[1]) ? $value[1] : 'not found';
    }

    return $ipInfo;
}


function youtube_validator($url)
{
    $rx = '~
    ^(?:https?://)?              # Optional protocol
     (?:www\.)?                  # Optional subdomain
     (?:youtube\.com|youtu\.be)  # Mandatory domain name
     /watch\?v=([^&]+)           # URI with video id as capture group 1
     ~x';

    $has_match = preg_match($rx, $url, $matches);
}




//check if an image exists
function check_image_existance($path,$image_name)
{
    //buld the url
    $image_url=$path.$image_name;
    if (file_exists($image_url) !== false) {
        return true;
    }
}

//delete a file
function delete_image($path,$image_name)
{
    //images to delete
    $items=array(get_thumbnail($image_name),$image_name);

    //delete only if exists
    foreach($items as $item)
    {
        if(check_image_existance($path,$item))
        {
            unlink($path.$item);
        }
    }

}

function serialize_array(&$array, $root = '$root', $depth = 0)
{
    $items = array();

    foreach ($array as $key => &$value) {
        if (is_array($value)) {
            serialize_array($value, $root . '[\'' . $key . '\']', $depth + 1);
        } else {
            $items[$key] = $value;
        }
    }

    if (count($items) > 0) {
        echo $root . ' = array(';

        $prefix = '';
        foreach ($items as $key => &$value) {
            echo $prefix . '\'' . $key . '\' => \'' . addslashes($value) . '\'';
            $prefix = ', ';
        }

        echo ');' . "\n";
    }
}


if (!function_exists('array_to_pipes')) {
    function array_to_pipes($array)
    {
        return '|' . implode('|', $array) . '|';
    }
}

if (!function_exists('pipes_to_array')) {
    function pipes_to_array($piped_string)
    {
        //do only if a string is passed
        if ($piped_string) {
            $tags = explode('|', $piped_string);
            $array_values = array();

            foreach ($tags as $tag) {
                //save only tags with values
                if ($tags <> '' && !in_array($tag, $array_values)) {
                    $array_values[] = $tag;
                }
            }

            return $array_values;
        } else {
            return NULL;
        }

    }
}

/**
 * Formats a line (passed as a fields  array) as CSV and returns the CSV as a string.
 * Adapted from http://us3.php.net/manual/en/function.fputcsv.php#87120
 */
function array_to_csv(array &$fields, $delimiter = ',', $enclosure = '"', $encloseAll = false, $nullToMysqlNull = false)
{
    $delimiter_esc = preg_quote($delimiter, '/');
    $enclosure_esc = preg_quote($enclosure, '/');

    $output = array();
    foreach ($fields as $field) {
        if ($field === null && $nullToMysqlNull) {
            $output[] = 'NULL';
            continue;
        }

        // Enclose fields containing $delimiter, $enclosure or whitespace
        if ($encloseAll || preg_match("/(?:${delimiter_esc}|${enclosure_esc}|\s)/", $field)) {
            $output[] = $enclosure . str_replace($enclosure, $enclosure . $enclosure, $field) . $enclosure;
        } else {
            $output[] = $field;
        }
    }

    return implode($delimiter, $output);
}



function delete_all_files_in_directory($path)
{
    $files = glob($path); // get all file names
    foreach ($files as $file) { // iterate files
        if (is_file($file))
            unlink($file); // delete file
    }
}

function delete_files_in_directory_v2($target)
{
    if (is_dir($target)) {
        $files = glob($target . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned

        foreach ($files as $file) {
            delete_files($file);
        }

        rmdir($target);
    } elseif (is_file($target)) {
        unlink($target);
    }
}

function str_rand($length = 8, $output = 'alphanum')
{
    // Possible seeds
    $outputs['alpha'] = 'abcdefghijklmnopqrstuvwqyz';
    $outputs['numeric'] = '0123456789';
    $outputs['alphanum'] = 'abcdefghijklmnopqrstuvwqyz0123456789';
    $outputs['hexadec'] = '0123456789abcdef';

    // Choose seed
    if (isset($outputs[$output])) {
        $output = $outputs[$output];
    }

    // Seed generator
    list($usec, $sec) = explode(' ', microtime());
    $seed = (float)$sec + ((float)$usec * 100000);
    mt_srand($seed);

    // Generate
    $str = '';
    $output_count = strlen($output);
    for ($i = 0; $length > $i; $i++) {
        $str .= $output{mt_rand(0, $output_count - 1)};
    }

    return $str;
}

function months_array()
{
    $months = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");
    return $months;
}

function get_month($number)
{
    $month = '';
    foreach (months_array() as $key => $value) {

        if ($key == $number) {
            $month = $value;
        }


    }
    return $month;
}

function round_up($number,$precision=0){
    return round($number, $precision, PHP_ROUND_HALF_UP);
}
function round_down($number,$precision=0){
    return round($number, $precision, PHP_ROUND_HALF_DOWN);
}
function round_even($number,$precision=0){
    return round($number, $precision, PHP_ROUND_HALF_EVEN);
}