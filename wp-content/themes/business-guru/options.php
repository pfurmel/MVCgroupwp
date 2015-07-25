<?php

	function bguru_register_settings(){
   
		

		add_option('bguru_options');
		 
		register_setting('tgbusinessguru', 'bguru_options');
	}

	add_action('admin_init', 'bguru_register_settings');
	function bguru_register_options_page(){
		add_theme_page('Business Guru Options', 'Theme Customizer', 'edit_theme_options', 'bguru-options', 'bguru_options_page');
	}

	add_action('admin_menu', 'bguru_register_options_page');
	
	function bguru_options_page(){
		$options=get_option('bguru_options');
	
		?>
<div class="wrap">
	<?php
 screen_icon(); ?>
	<h1>Business Guru Options</h1>
	<form method="post" action="options.php"> 
		<?php
 settings_fields('tgbusinessguru'); ?>
			<table class="form-table">
				<tr valign="top">
					<th><h2>General</h2><th>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="bguru_logo">Logo:</label></th>
					<td><input type="text" id="bguru_logo" size="50" name="bguru_options[bguru_logo]" value="<?php
 echo $options['bguru_logo']; ?>" /></td>
				</tr>
				<tr valign="top">
					<th><h2>Social Links</h2><th>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="bguru_vimeo">Vimeo:</label></th>
					<td><input type="text" id="bguru_vimeo" size="50" name="bguru_options[bguru_vimeo]" value="<?php
 echo $options['bguru_vimeo']; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="bguru_skype">Skype:</label></th>
					<td><input type="text" id="bguru_skype" size="50" name="bguru_options[bguru_skype]" value="<?php
 echo $options['bguru_skype']; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="bguru_dribbble">Dribbble:</label></th>
					<td><input type="text" id="bguru_dribbble" size="50" name="bguru_options[bguru_dribbble]" value="<?php
 echo $options['bguru_dribbble']; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="bguru_youtube">YouTube:</label></th>
					<td><input type="text" id="bguru_youtube" size="50" name="bguru_options[bguru_youtube]" value="<?php
 echo $options['bguru_youtube']; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="bguru_twitter">Twitter:</label></th>
					<td><input type="text" id="bguru_twitter" size="50" name="bguru_options[bguru_twitter]" value="<?php
 echo $options['bguru_twitter']; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="bguru_facebook">Facebook:</label></th>
					<td><input type="text" id="bguru_facebook" size="50" name="bguru_options[bguru_facebook]" value="<?php
 echo $options['bguru_facebook']; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="bguru_feed">Feed:</label></th>
					<td><input type="text" id="bguru_feed" size="50" name="bguru_options[bguru_feed]" value="<?php
 echo $options['bguru_feed']; ?>" /></td>
				</tr>
				<tr valign="top">
					<th><h2>Configure Slider</h2><th>
				</tr>
				<tr valign="top">
					<th><h3>Slide 1</h3><th>
					Leave the first slide empty to remove the slider:
				</tr>
				<tr valign="top">
					<th scope="row"><label for="bguru_slide_one_image">Image:</label></th>
					<td><input type="text" id="bguru_slide_one_image" size="50" name="bguru_options[bguru_slide_one_image]" value="<?php
 echo $options['bguru_slide_one_image']; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="bguru_slide_one_heading">Heading:</label></th>
					<td><input type="text" id="bguru_slide_one_heading" size="50" name="bguru_options[bguru_slide_one_heading]" value="<?php
 echo $options['bguru_slide_one_heading']; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="bguru_slide_one_text">Description:</label></th>
					<td><textarea type="text" id="bguru_slide_one_text" style="width:439px;height:100px;" name="bguru_options[bguru_slide_one_text]"><?php  echo $options['bguru_slide_one_text']; ?></textarea></td>
				</tr>
				<tr valign="top">
					<th><h3>Slide 2</h3><th>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="bguru_slide_two_image">Image:</label></th>
					<td><input type="text" id="bguru_slide_two_image" size="50" name="bguru_options[bguru_slide_two_image]" value="<?php
 echo $options['bguru_slide_two_image']; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="bguru_slide_two_heading">Heading:</label></th>
					<td><input type="text" id="bguru_slide_two_heading" size="50" name="bguru_options[bguru_slide_two_heading]" value="<?php
 echo $options['bguru_slide_two_heading']; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="bguru_slide_two_text">Description:</label></th>
					<td><textarea type="text" id="bguru_slide_two_text" style="width:439px;height:100px;" name="bguru_options[bguru_slide_two_text]"><?php  echo $options['bguru_slide_two_text']; ?></textarea></td>
				</tr>
				<tr valign="top">
					<th><h3>Slide 3</h3><th>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="bguru_slide_three_image">Image:</label></th>
					<td><input type="text" id="bguru_slide_three_image" size="50" name="bguru_options[bguru_slide_three_image]" value="<?php
 echo $options['bguru_slide_three_image']; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="bguru_slide_three_heading">Heading:</label></th>
					<td><input type="text" id="bguru_slide_three_heading" size="50" name="bguru_options[bguru_slide_three_heading]" value="<?php
 echo $options['bguru_slide_three_heading']; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="bguru_slide_three_text">Description:</label></th>
					<td><textarea type="text" id="bguru_slide_three_text" style="width:439px;height:100px;" name="bguru_options[bguru_slide_three_text]"><?php  echo $options['bguru_slide_three_text']; ?></textarea></td>
				</tr>
				<tr valign="top">
					<th><h2>Slogan Settings (Below Slider)</h2><th>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="bguru_slogan_heading">Heading:</label></th>
					<td><input type="text" id="bguru_slogan_heading" size="50" name="bguru_options[bguru_slogan_heading]" value="<?php
 echo $options['bguru_slogan_heading']; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="bguru_slogan_description">Container:</label></th>
					<td><input type="text" id="bguru_slogan_description" size="50" name="bguru_options[bguru_slogan_description]" value="<?php
 echo $options['bguru_slogan_description']; ?>" /></td>
				</tr>
			</table>
		<?php
 submit_button(); ?>
	</form>
</div>
<?php
 } ?>