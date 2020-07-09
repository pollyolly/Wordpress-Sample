<?php

//CURL
function curlingData($url, $credentials) {
         $options = array(
            CURLOPT_RETURNTRANSFER => true, // return web page
            CURLOPT_HEADER => false, // don't return headers
            CURLOPT_FOLLOWLOCATION => true, // follow redirects
            CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
            CURLOPT_ENCODING => "", // handle compressed
            CURLOPT_USERAGENT => "ilc website", // name of client
            CURLOPT_AUTOREFERER => true // set referrer on redirect
            //CURLOPT_CONNECTTIMEOUT => 120, // time-out on connect
            //CURLOPT_TIMEOUT => 120, // time-out on response
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt_array($curl, $options);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($credentials));
       // $errmsg = curl_error($curl);
       // $cinfo = curl_getinfo($curl);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
             //print_r($errmsg);
             //print_r($cinfo);
    }

function GoogleSheet($url) {
        $options = array(
            CURLOPT_RETURNTRANSFER => true, // return web page
            CURLOPT_HEADER => false, // don't return headers
            CURLOPT_FOLLOWLOCATION => true, // follow redirects
            CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
            CURLOPT_ENCODING => "", // handle compressed
            CURLOPT_USERAGENT => "test", // name of client
            CURLOPT_AUTOREFERER => true // set referrer on redirect
            //CURLOPT_CONNECTTIMEOUT => 30000, // time-out on connect
            //CURLOPT_TIMEOUT => 30000 // time-out on response
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        //curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt_array($curl, $options);
        //curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        $errmsg = curl_error($curl);
        $cinfo = curl_getinfo($curl);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
             //print_r($errmsg);
             //print_r($cinfo);
        }
//CURL

?>
