# PHP 汉字转拼音工具

 目前最全面的汉字词典

 包含20902个基本汉字+5059生僻字


## 使用方法:

1. 载入本工具类

~~~shell
composer require tekintian/pinyin_utils
~~~

2. 使用本工具

~~~php
<?php
// 载入自动加载： 如果使用框架的话这个步骤可以忽略。
require_once __DIR__ . '/vendor/autoload.php';

// 拼音转换测试
$str = \tekintian\pinyin_utils\Pinyin::convert("云南网");

echo $str;

~~~


