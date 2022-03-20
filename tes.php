<?php 

$data['field1'] = 1234;
$data['field2'] = 'abcd';

$command = table_insert_cmd('tabel1', $data);

$query = $db->prepare($command);

if (!$query->execute($data)){
 pdo_execute_error($query, 'Tidak bisa update data');
}


$command = table_update_cmd('tabel1', $data, "id = '1'");

$query = $db->prepare($command);

if (!$query->execute($data)){
 pdo_execute_error($query, 'Tidak bisa update data');
}

unset($data);
unset($query);
unset($command);


function table_insert_cmd($table_name, $data) {
 $fields = '';
 $count = count($data);
 $i = 1;
 foreach ($data as $key => $value) {

  $fields .= $key." = :".$key;

  if($i != $count)
   $fields .= ", ";

  $i++;
 }

 $output = "INSERT INTO ".$table_name." SET ".$fields;

 return $output;
}

function table_update_cmd($table_name, $data, $criteria) {
 $fields = '';
 $count = count($data);
 $i = 1;
 foreach ($data as $key => $value) {

  $fields .= $key." = :".$key;

  if($i != $count)
   $fields .= ", ";

  $i++;
 }

 $output = "UPDATE ".$table_name." SET ".$fields." WHERE ".$criteria;

 return $output;
}

function pdo_execute_error($e, $added_message = '') {

 global $db;

 print_r($e->errorInfo());
 
 $message = "Host : ".php_uname('n')."\n\n";
 $message .= "__FILE__ : ".__FILE__."\n\n";
 $message .= "PHP_SELF : ".$_SERVER['PHP_SELF']."\n\n";

 if(!empty($added_message))
  $message .= $added_message . " : \n";
 else
  $message .= "Error : \n";

 foreach($e->errorInfo() as $err) {
 
  $message .= $err.' - ';
  
 }

 tg_send_message($message);

}

function tg_send_message($message) {

 // function untuk kirim message dari bot telegram

}
