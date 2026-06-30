<?php
/**
 * Header template.
 *
 * @package SelectaTheme
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'selecta-theme' ); ?></a>

<header class="site-header">
	<?php get_template_part( 'template-parts/components/site-header-bar' ); ?>
	<?php get_template_part( 'template-parts/components/header-nav-panels' ); ?>
</header>

<?php get_template_part( 'template-parts/components/mobile-menu' ); ?>
