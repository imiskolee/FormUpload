<?php
include "FormUpload.class.php";

$form = new FormUpload('http://xxxxxxx');
$form->addPart('number',1);
$form->addPart('float',1.234);
$form->addPart('string',"string");
$form->addPart("file","filefilefile",FormUpload::$MIME_TEXT,'test.txt');

echo $form->submit();