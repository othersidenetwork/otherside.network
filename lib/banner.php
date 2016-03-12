<?php

function otherside_banner() {
	global $otherside_network_config_object;
	if ($otherside_network_config_object === false) {
		return;
	}
?>
<div id="otherside-network-banner">
	<a href="http://otherside.network">The Other Side Podcast Network :</a>
	<?php foreach ($otherside_network_config_object->categories as $key => $category) {?>
	<div class="otherside-network-banner-dropdown">
		<span><?php echo _e($category->name, 'otherside_plugin_domain'); ?></span>
		<div class="otherside-network-banner-category">
			<?php foreach ($category->podcasts as $key => $podcast) {
			$url = $otherside_network_config_object->podcasts->$podcast->url;
			$url = add_query_arg(array(
				'utm_campaign' => 'syndication',
				'utm_source' => sanitize_title(get_bloginfo('name', 'display')),
				'utm_medium' => 'network',
				'utm_content' => 'banner'
			), $url);?>
			<p><a href="<?php echo $url; ?>"><?php echo $otherside_network_config_object->podcasts->$podcast->name; ?></a></p>
			<?php } ?>
		</div>
	</div>
	<?php } ?>
</div>
<?php
}

add_action('wp_head', 'otherside_banner');
wp_enqueue_style('otherside-banner', plugin_dir_url(__FILE__) . '../css/banner.css', false, '1.0', 'all');

?>