<?php

/**
 * _error.php
 * User: kzoltan
 * Date: 2022-06-26
 * Time: 14:15
 */

/** @var $exception \Exception */
?>

<h1><?php echo $exception->getCode() ?> - <?php echo $exception->getMessage() ?></h1>