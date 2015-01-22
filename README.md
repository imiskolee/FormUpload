##RFC 1867 implement for php

* 实现了HTML的Form中enctype="multipart/form-data" 的数据提交
* 主要用作直接在php进行二进制文件上传，而无需建立临时文件。使程序降低的本地环境依赖，提高稳定性。

###使用方法

###对象构造
```php
$form = new FormUpload('http:///')
```
###表单构造
```php

//input[type="text"] input[type="number"] input[type="email"] ....
$form->addPart('number'，1);
$form->addPart('float',1);
$form->addPart('string',"string");

//input[type="file"]
$form->addPart("file","filefilefile",FormUpload::$MIME_TEXT,'test.txt');

/**
当$mime不为空的时候，将被定义为文件上传
$filename为空的时候，将使用缺省的默认文件名
**/
$form->addPart($filed,$content,$mime='',$filename='');
```

###表单提交
```php
$result = $form->submit();
```

