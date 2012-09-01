Cache\_Casual
=============

A casual way to cache your data with PHP.

Synopsis
--------

You can treat cache object just like a hash.

```php
<?php
require_once 'Cache/Casual.php';
require_once 'Cache/Casual/Container/File.php';

$container = new Cache_Casual_Container_File('/tmp');
$cache = new Cache_Casual($container, 3600);

// Read from cache.
$article = $cache['article'];
if (is_null($article)) {
    // Cache is not stored
    $article = fetchArticleFromDatabase();

    // Stores your data into cache.
    $cache['article'] = $article;
}
```

Custom cache container
----------------------

You can write your custom cache container.

Things you have to do is to extend `Cache_Casual_ContainerAbstract`,  
and to implement `Cache_Casual_ContainerInterface` methods.

For example, see `Cache_Casual_Container_Memory` class.

Limitation
----------

With some cache containers, cached data should be both serializable and unserializable.

Author
------

Yuya Takeyama
