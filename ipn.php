<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 03/10/2017
 * Time: 15:35
 */


$apiKey = '0a58c37e1b2bdc64462637d2dd8a1a3ca4c312884a5d89a6031d41853e1561d6';
$apiSecret = '98dc76a3c2c4744cbca69f107ed21986641b6160ec5e562a6dfd7c5736f777bb';

$type_event = !empty($_POST['type_event']) ? $_POST['type_event'] : null;
$custom_field = !empty($_POST['custom_field']) ? json_decode($_POST['custom_field']) : null;
$api_key_sha256 = !empty($_POST['api_key_sha256']) ? $_POST['api_key_sha256'] : null;
$api_secret_sha256 = !empty($_POST['api_secret_sha256']) ? $_POST['api_secret_sha256'] : null;


if(hash('sha256', $apiKey) === $api_key_sha256 && hash('sha256', $apiSecret) === $api_secret_sha256)
{
   if($type_event === 'sale_complete')
   {
       $files = json_decode(file_get_contents('article.json'), true);
       $key = array_search($custom_field->item_id, array_column($files['articles'], 'id'));
       if($key !== false )
       {
           $files['articles'][$key]['stock'] = $files['articles'][$key]['stock'] - 1;
           file_put_contents('article.json', json_encode($files, JSON_PRETTY_PRINT|JSON_HEX_QUOT|JSON_UNESCAPED_UNICODE));
           echo 'success';
       }
       else{
           echo 'key dont exist';
       }

   }
   else{
       echo 'other event : '.$type_event;
   }
}
else{
    echo 'not allowed';
}
