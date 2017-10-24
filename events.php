<?php
$events = array (

array ("title"=>"All Day Event","start"=>"2017-04-01"),
array ("title"=>"Event2","start"=>"2017-04-02")

);
$jsonEncode = json_encode($events);

//$file = fopen('events.json', "w");
//fwrite($file, 'working');
//fclose($file);
file_put_contents('events.json',$jsonEncode,FILE_APPEND, null);

if (file_put_contents('events.json',$jsonEncode,FILE_APPEND, null)) {
    echo 'working';
} else {
    echo 'not working';
}
?>
