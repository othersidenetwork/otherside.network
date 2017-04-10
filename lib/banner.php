<?php

if ( !function_exists( 'otherside_banner' ) ) {
function otherside_banner() {
	global $otherside_network_config_object;
	if ($otherside_network_config_object === false) {
		return;
	}
?>
<div id="otherside-network-banner" class="otherside-network-closed">
	<div id="otherside-network-title-wrapper">
		<a class="otherside-network-title" href="http://otherside.network">The Other Side Podcast Network : </a>
		<span class="otherside-network-toggle">Our other shows</span>
	</div>
	<?php foreach ($otherside_network_config_object->categories as $key => $category) {?>
	<div class="otherside-network-banner-dropdown">
		<span><?php echo __($category->name, 'otherside_plugin_domain'); ?></span>
		<div class="otherside-network-banner-category">
			<?php foreach ($category->podcasts as $subkey => $podcast) {
			$url = $otherside_network_config_object->podcasts->$podcast->url;
			$url = add_query_arg(array(
				'utm_campaign' => 'syndication',
				'utm_source' => sanitize_title(get_bloginfo('name', 'display')),
				'utm_medium' => 'network',
				'utm_content' => 'banner'
			), $url);?>
			<p><a href="<?php echo $url; ?>"><span class="otherside-network-link"><?php echo $otherside_network_config_object->podcasts->$podcast->name; ?></span></a></p>
			<?php } ?>
		</div>
	</div>
	<?php } ?>
</div>
<?php
}
}

add_action('wp_head', 'otherside_banner');

if ( !function_exists( 'otherside_enqueue_scripts_and_styles' ) ) {
	function otherside_enqueue_scripts_and_styles() {
		wp_enqueue_style('otherside-banner', plugin_dir_url(__FILE__) . '../css/banner.css', false, '1.0', 'all');
		wp_enqueue_script('otherside-script', plugin_dir_url(__FILE__) . '../js/banner.js', [ 'jquery' ], false, true );
	}
}
add_action( 'wp_enqueue_scripts', 'otherside_enqueue_scripts_and_styles' );


?>