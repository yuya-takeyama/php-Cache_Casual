ChangeLog of Cache\_Casual
==========================

2012-09-01
----------

* 1.1.0
    - Replaced `DateTime` and `DateInterval` with `timestamp()` for PHP 5.2 compatibility
		- Added `Cache_Casual_Container_PartitionedFile`

2011-08-14
----------

* 1.0.1-beta
    - Fixed loading of broken cache file (Cache\_Casual\_Container\_File)
    - Fixed to lock cache files. (Cache\_Casual\_Container\_File)
    - Fixed bootstrap.php not to load Cache\_Casual installed with pear.
    - Moved unit test files.

* 1.0.0-beta
    - 1st release.
