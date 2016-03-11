<?php
/*
Plugin Name:       Tools from the Other Side
Plugin URI:        https://github.com/othersidenetwork/otherside.network
Description:       Tools and widgets for members of The Other Side Podcast Network.
Version:           1.0.0
Require WP:        4.4
Require PHP:       5.3.0
Author:            Yannick Mauray
Author URI:        https://github.com/ymauray
License:           GNU General Public License v3
License URI:       http://www.gnu.org/licenses/gpl-3.0.html
Domain Path:       /languages
Text Domain:       otherside_plugin_domain
GitHub Plugin URI: https://github.com/othersidenetwork/otherside.network
GitHub Branch:     master
*/

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
		$title = apply_filters('widget_title', $instance['title']);
		echo $args['before_widget'];
		if (!empty($title)) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		$options = get_option('otherside_members_widget_options');
		$update_now = false;
		if (!isset($options['lastupdate'])) {
			$update_now = true;
		} else {
			$today = date_create(date('Y-m-d'));
			$last_update = date_create($options['lastupdate']);
			$interval = date_diff($last_update, $today);
			if ($interval->d >= $options['interval']) {
				$update_now = true;
			}			
		}
		if ($update_now) {
			$options['content'] = file_get_contents($instance['url']);
			$options['lastupdate'] = date('Y-m-d');
			update_option('otherside_members_widget_options', $options);
		}
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

		if (isset($instance['url'])) {
			$url = $instance['url'];
		} else {
			$url = 'http://otherside.network/linkexchange.js';
		}
		$options = get_option('otherside_members_widget_options');
		if (isset($options['interval'])) {
			$interval = $options['interval'];
		} else {
			$interval = 7;
		}
?>
<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo _e('Title:'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id('url'); ?>"><?php echo _e('Source :'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo esc_attr($url); ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id('interval'); ?>"><?php echo _e('Days between updates :', 'otherside_plugin_domain'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('interval'); ?>" name="<?php echo $this->get_field_name('interval'); ?>" type="text" value="<?php echo esc_attr($interval); ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id('lastupdate'); ?>"><?php echo _e('Last update :'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('lastupdate'); ?>" name="<?php echo $this->get_field_name('lastupdate'); ?>" type="text" value="<?php echo $options['lastupdate']; ?>" readonly="readonly" />
</p>
<?php
	}

	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
		$instance['url'] = (!empty($new_instance['url'])) ? strip_tags($new_instance['url']) : '';
		$options = get_option('otherside_members_widget_options');
		$options['interval'] = $new_instance['interval'];
		if (!empty($new_instance['lastupdate'])) {
			$options['lastupdate'] = $new_instance['lastupdate'];
		} else {
			unset($options['lastupdate']);
		}
		update_option('otherside_members_widget_options', $options);
		return $instance;
	}
}

function otherside_load_widget() {
	register_widget('OtherSide_Members_Widget');
}

add_action('widgets_init', 'otherside_load_widget');


function otherside_banner() {
?>
<div id="otherside-network-banner">
	<a href="http://otherside.network">The Other Side Podcast Network :</a>
	<div class="otherside-network-banner-dropdown">
		<span><?php echo _e('Discussion', 'otherside_plugin_domain'); ?></span>
		<div class="otherside-network-banner-category">
			<p><a href="http://duffercast.org/">Duffercast</a></p>
			<p><a href="http://unseenstudio.co.uk/category/tuxjam-ogg/">Tuxjam</a></p>
		</div>
	</div>
	<div class="otherside-network-banner-dropdown">
		<span><?php echo _e('Music', 'otherside_plugin_domain'); ?></span>
		<div class="otherside-network-banner-category">
			<p><a href="http://unseenstudio.co.uk/category/ccjam-mp3/">CCJam</a></p>
			<p><a href="http://www.euterpia-radio.fr">Euterpia&nbsp;Radio</a></p>
			<p><a href="http://open-country.co.uk">Open&nbsp;Country</a></p>
			<p><a href="http://thebugcast.org">The&nbsp;Bugcast</a></p>
		</div>
	</div>
	<div class="otherside-network-banner-dropdown">
		<span><?php echo _e('Technology', 'otherside_plugin_domain'); ?></span>
		<div class="otherside-network-banner-category">
			<p><a href="http://unseenstudio.co.uk/category/tuxjam-ogg/">Tuxjam</a></p>
		</div>
	</div>
</div>
<?php
}

add_action('wp_head', 'otherside_banner');

wp_enqueue_style('otherside-banner', plugin_dir_url(__FILE__) . '/otherside.network.css', false, '1.0', 'all');

?>
