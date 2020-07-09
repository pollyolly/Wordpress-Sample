<?php settings_errors(); ?>
<form method="post" action="options.php">
<?php settings_fields( 'contact-box_settings_group'); ?>
<?php do_settings_sections('contact_box_setting_options'); ?>
<?php submit_button(); ?>
</form>
