<?php
class OtherSide_Members_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'otherside_members_widget', // ID
			__('Network members', 'otherside_plugin_domain'), // Name
			array(
				'description' => __('Displays a list of member podcasts', 'otherside_plugin_domain') // Description
			)
		);
	}

	/**
	 * Front end
	 */
	public function widget($args, $instance) {
		global $otherside_network_config_object;
		$title = apply_filters('widget_title', $instance['title']);
		echo $args['before_widget'];
		if (!empty($title)) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
?>
<ul id="otherside-widget">
	<?php foreach ($otherside_network_config_object->podcasts as $slug => $podcast) {
	$url = $podcast->url;
	$url = add_query_arg(array(
		'utm_campaign' => 'syndication',
		'utm_source' => sanitize_title(get_bloginfo('name', 'display')),
		'utm_medium' => 'network',
		'utm_content' => 'widget'
	), $url);?>

	<li><a href="<?php echo $url; ?>"><?php echo $podcast->name; ?></a></li>
	<?php } ?>
</ul>
<?php
		if (!empty($options['content'])) {
			echo "<script>" . $options['content'] . "</script>";
		}

		echo $args['after_widget'];
	}

	/**
	 * Back end
	 */
	public function form($instance) {
		if (isset($instance['title'])) {
			$title = $instance['title'];
		} else {
			$title = __('The Other Side', 'otherside_plugin_domain');
		}
?>
<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo _e('Title:'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
</p>
<?php
	}

	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		return $instance;
	}
}

function otherside_load_widget() {
	register_widget('OtherSide_Members_Widget');
}

add_action('widgets_init', 'otherside_load_widget');

?>