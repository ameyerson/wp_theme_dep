<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
	<head>
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">

	    <title><?php bloginfo() ?><?php wp_title( '-' ); ?></title>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	    <!-- icon -->
	    <link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico?v=<?php echo md5_file('favicon.ico') ?>" type="image/x-icon">
	    <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico?v=<?php echo md5_file('favicon.ico') ?>" type="image/x-icon">

	    <?php wp_head(); ?>

	</head>

<body <?php body_class(); ?>>