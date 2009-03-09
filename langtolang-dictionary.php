<?php
/*
Plugin Name: Langtolang Dictionary
Plugin URI: http://www.langtolang.com/external/wordpress/
Description: Langtolang Dictionary Sidebar Widget for WordPress provides a multilingual dictionary translating from/to English, Arabic, Chinese Simplified, Chinese Traditional, Czech, Danish, Dutch, Estonian, Finnish, French, German, Greek, Hungarian, Icelandic, Indonesian, Italian, Japanese, Korean, Latvian, Lithuanian, Norwegian, Polish, Portuguese Brazil, Portuguese Portugal, Romanian, Russian, Slovak, Slovenian, Spanish, Swedish, Turkish from the wordpress sidebar.


Version: 1.0.0
Author: Baris Efe
Author URI: http://www.langtolang.com
*/

function wp_widget_langtolang($args) {
	extract($args);
	$options = get_option('widget_langtolang');
	$title = $options['title'];
	if ( empty($title) )
		$title = 'Langtolang Dictionary';
	$search_button_label = $options['search_button_label'];
	if ( empty($search_button_label) )
		$search_button_label = 'Search';
		
	$selectFrom = $options['selectFrom'];
	if ( empty($selectFrom) )
		$selectFrom = 'english';
	$htmlSelectFrom = '<select name="selectFrom">'.prepare_html_language_options($selectFrom).'</select>';

	$selectTo = $options['selectTo'];
	if ( empty($selectTo) )
		$selectTo = 'spanish';
	$htmlSelectTo = '<select name="selectTo">'.prepare_html_language_options($selectTo).'</select>';
?>
		<?php echo $before_widget; ?>
			<?php $title ? print($before_title . $title . $after_title) : null; ?>
			<form name="langtolang" method="get" action="http://www.langtolang.com/" target="_blank">
			<input name="txtLang" id="txtLang" maxlength="100"  type="text" style="max-width: 150px;" /><br>
			<?php echo  $htmlSelectFrom?>
			<?php echo  $htmlSelectTo?>
			<br><input type="submit" name="Submit" value="<?php echo $search_button_label?>">
			</form>
		<?php echo $after_widget; ?>
<?php
}

function prepare_html_language_options($default_language) {
	$LANGUAGES = array(
						"english"=>"English",
						"arabic"=>"Arabic",
						"chinese_simplified"=>"Chinese Simplified",
						"chinese_traditional"=>"Chinese Traditional",
						"czech"=>"Czech",
						"danish"=>"Danish",
						"dutch"=>"Dutch",
						"estonian"=>"Estonian",
						//"esperanto"=>"Esperanto",
						"finnish"=>"Finnish",
						"french"=>"French",
						"german"=>"German",
						"greek"=>"Greek",
						"hungarian"=>"Hungarian",
						"icelandic"=>"Icelandic",
						"indonesian"=>"Indonesian",
						"italian"=>"Italian",
						"japanese"=>"Japanese",
						"korean"=>"Korean",
						"latvian"=>"Latvian",
						"lithuanian"=>"Lithuanian",
						"norwegian"=>"Norwegian",
						"polish"=>"Polish",
						"portuguese_brazil"=>"Portuguese Brazil",
						"portuguese_portugal"=>"Portuguese Portugal",
						"romanian"=>"Romanian",
						"russian"=>"Russian",
						//"serbo_croat"=>"Serbo Croat",
						"slovak"=>"Slovak",
						"slovenian"=>"Slovenian",
						"spanish"=>"Spanish",
						//"swahili"=>"Swahili",
						"swedish"=>"Swedish",
						"turkish"=>"Turkish");
	
	$html="";
	foreach ($LANGUAGES as $key => $value) {
		if ($default_language==$key) {
			$html .= '<option selected="selected" value="'.$key.'" label="'.$value.'">'.$value.'</option>';
		} else {
			$html .= '<option value="'.$key.'" label="'.$value.'">'.$value.'</option>';
		}	
	}
	return $html;
}

function wp_widget_langtolang_control() {
		
	$options = $newoptions = get_option('widget_langtolang');
	if ( $_POST["langtolang-submit"] ) {
		$newoptions['title'] = strip_tags(stripslashes($_POST["langtolang-title"]));
		$newoptions['search_button_label'] = stripslashes($_POST["langtolang-search-button-label"]);
		$newoptions['selectFrom'] = stripslashes($_POST["langtolang-selectFrom"]);
		$newoptions['selectTo'] = stripslashes($_POST["langtolang-selectTo"]);
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('widget_langtolang', $options);
	}
	$title = attribute_escape($options['title']);
	$search_button_label = attribute_escape($options['search_button_label']);
	$default_language_from = attribute_escape($options['selectFrom']);
	if ( empty($default_language_from) )
		$default_language_from = 'english';
	$default_language_to = attribute_escape($options['selectTo']);
	if ( empty($default_language_to) )
		$default_language_to = 'spanish';
	?>
	<p>
		<label for="langtolang-title"><?php _e('Title'); ?></label>
		<br /><input style="width: 200px;" id="langtolang-title" name="langtolang-title" type="text" value="<?php echo $title; ?>" />
	</p>
	<p>
		<label for="langtolang-search-button-label"><?php _e('Search Button Label'); ?></label>
		<br /><input style="width: 200px;" id="langtolang-search-button-label" name="langtolang-search-button-label" type="text" value="<?php echo $search_button_label; ?>" />
	</p>
	<p>
		<label for="langtolang-selectFrom"><?php _e('Default From'); ?></label>
		<br /><select id="langtolang-selectFrom" name="langtolang-selectFrom">
<?php 
	echo prepare_html_language_options($default_language_from);
?>
		</select>
	</p>
	<p>
		<label for="langtolang-selectTo"><?php _e('Default To'); ?></label>
		<br /><select id="langtolang-selectTo" name="langtolang-selectTo">
<?php 
	echo prepare_html_language_options($default_language_to);
?>
		</select>
	</p>
		<input type="hidden" id="langtolang-submit" name="langtolang-submit" value="1" />
<?php
}

function wp_widget_langtolang_register() {
	$dimension = array('height' => 180, 'width' => 200);
	$class = array('classname' => 'widget_langtolang');
	wp_register_sidebar_widget('langtolang', __('Langtolang Dictionary'), 'wp_widget_langtolang', $class);
	wp_register_widget_control('langtolang', __('Langtolang Dictionary'), 'wp_widget_langtolang_control', $dimension);
}

add_action('plugins_loaded','wp_widget_langtolang_register');

?>