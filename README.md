Cache\_Casual
=============

Casual cache system for PHP.

Synopsis
--------

Just a draft!

```php
<?php
$container = new Cache_Casual_Container_File('/tmp');
$cache = new Cache_Casual($container, 3600);

if (isset($cache['article'])) {
    $article = $cache['article']
} else {
    $article = fetchArticleFromDatabase();
    $cache['article'] = $article;
}
```

Author
------

Yuya Takeyama
