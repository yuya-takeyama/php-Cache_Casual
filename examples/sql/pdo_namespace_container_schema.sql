CREATE TABLE `cache_casual_data` (
`id`  int UNSIGNED NOT NULL AUTO_INCREMENT ,
`namespace`  varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'Namespace of cache data' ,
`key`  varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT 'Key of cached data' ,
`content`  blob NOT NULL COMMENT 'Serialized content of cached data' ,
`lifetime`  int NOT NULL COMMENT 'Lifetime of the data' ,
`last_modified`  int NOT NULL COMMENT 'Timestamp of the time when the data is last modified' ,
PRIMARY KEY (`id`),
UNIQUE INDEX `namespce_and_key` (`namespace`, `key`) 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_bin
COMMENT='Cache data of Cache_Casual\'s NamespcePdo container';
