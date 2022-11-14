<?php

/**
 * _404.php
 * User: kzoltan
 * Date: 2022-05-17
 * Time: 7:21
 */

/** @var $exception \Exception */

?>

<h1><?php echo $exception->getCode() ?> - <?php echo $exception->getMessage() ?></h1>