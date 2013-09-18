<?php
   header('Content-Type: text/xml');
   $curl = curl_init();
   curl_setopt($curl, CURLOPT_URL, 'http://www.renewableenergyworld.com/rss/renews.rss');
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
   curl_exec($curl);
   curl_close($curl);
?>
