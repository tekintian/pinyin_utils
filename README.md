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

use \tekintian\pinyin_utils\Pinyin;

// 拼音转换测试
$py = Pinyin::convert("云南网");

echo $py;

~~~



## sources

## How to autoload the PSR-4 way?
PSR-4 is the newest standard of autoloading in PHP, and it compels us to use namespaces.

We need to take the following steps in order to autoload our classes with PSR-4:

a. Put the classes that we want to autoload in a dedicated directory. For example, it is customary to convene the classes that we write into a directory called src/, thus, creating the following folder structure:
~~~html
your-website/
  src/
    Db.php
    Page.php
    User.php
~~~
b. Give the classes a namespace. We must give all the classes in the src/ directory the same namespace. For example, let's give the namespce Acme to the classes. This is what the Page class is going to look like:
~~~php
<?php
namespace Acme;

class Page {
    public function __construct()
    {
        echo "hello, i am a page.";
    }
}
~~~
We give the same namespace Acme to all of the classes in the src/ directory.
c. Point the namespace to the src/ directory in the composer.json file . We point the directory that holds the classes to the namespace in the composer.json file. For example, this is how we specify in the composer.json file that we gave the namespace Acme to the classes in the src/ directory:
~~~json
{
  "autoload": {
    "psr-4": {
      "Acme\\":"src/"
    }
  }
}
~~~
- We use the psr-4 key.

	The namespace Acme points to the src/ directory.
	The namespace has to end with \\. For example, "Acme\\".
	You can replace the generic Acme with the name of your brand or website.

d. Update the Composer autoloader:
~~~shell
$ composer dumpautoload -o
~~~
e. Import the namespace to your scripts. The scripts need to import the namespace as well as the autoloader, e.g., index.php:
~~~php
<?php 
require "vendor/autoload.php";

use Acme\Db;
use Acme\User;
use Acme\Page;
 
$page1 = new Page();
~~~
How to autoload if the directory structure is complex?
Up till now, we demonstrated autoloading of classes that are found directly underneath the src/ folder, but how can we autoload a class that is found in a subdirectory? For example, we may want to move the Page class into the Pages directory and, thus, create the following directory tree:
~~~html
your-website/
  src/
    Db.php
    User.php
    Pages/
      Page.php
~~~
These are the steps that we need to follow:
a. Redefine the namespace. We need to give the Page class a namespace in accordance with its new location in the src/Pages directory.
~~~php
<?php
namespace Acme\Pages;

public class Page {
    function __construct()
    {
        echo "hello, i am a page.";
    }
}
~~~
b. Use the namespaces in the scripts:
~~~php
<?php
require "vendor/autoload.php";

use Acme\Db;
use Acme\User;
use Acme\Pages\Page;


$page1 = new Page();

~~~
Conclusion

As we demonstrated in the last two tutorials, Composer is a powerful tool that can help us to both manage and autoload our own classes as well as others. Now, that we have such a powerful tool under our belt we're entitled to fully enjoy the best that modern-day PHP has to offer!

https://phpenthusiast.com/blog/how-to-autoload-with-composer
https://phpenthusiast.com/object-oriented-php-tutorials
