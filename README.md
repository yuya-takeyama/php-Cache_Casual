`Cache_Casual`
==============

Casual cache system for PHP.

Synopsis
--------

Just a draft!

```php
<?php
$container = new Cache_Casual_Container_Filesystem(array(
    'directory' => '/tmp',
    'lifetime'  => 3600,
));
$cache = new Cache_Casual($container);

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
