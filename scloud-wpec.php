<?php
/*
Plugin Name: scloud-wpec
Description: Customizing WP Easy Cart plugin for SanCloud
Version: 1.0
Author: Make-Websites 
Author URI: www.make-websites.co.uk
License: GPLv2
*/

/*if (!defined('SCWPEC_DIR')) {
define( 'SCWPEC_DIR', plugin_dir_path(__FILE__) ); }
if (!defined('SCWPEC_URL')) {
define( 'SCWPEC_URL', plugin_dir_url(__FILE__) ); }*/

add_action('admin_menu', 'scwpec_add_page');
function scwpec_add_page() {
	add_options_page( 'SCWPEC options', 'SCWPEC options', 'manage_options', 'scwpec', 'scwpec_option_page' );
}

// Draw the option page
function scwpec_option_page() {
	?>
	<div class="wrap">
            <h2 class="dashicons-before dashicons-admin-tools"> SCWPEC options</h2>
            	<form action="options.php" method="post">
			<?php settings_fields('scwpec_options'); ?>
			<?php do_settings_sections('scwpec'); ?>
			<input name="Submit" type="submit" value="Save Changes" />
		</form> 
        </div>
    <?php
	$correct = get_option( 'scwpec_connected' );
        if ($correct) { // Options correct whole process start
            echo 'Datos correctos</br>';
            require_once 'includes/createCT.php';
            new createCT();
            require_once 'includes/createOT.php';
            new createOT();
	} 
        else
        echo '<h3>Please update the settings</h3>';    
        
}

// Register and define the settings
add_action('admin_init', 'scwpec_admin_init');
function scwpec_admin_init(){
	register_setting(
		'scwpec_options',
		'scwpec_options',
                'scwpec_validate'
	);
	add_settings_section(
		'scwpec_main',
		'SanCloud - Customisation of the WP Easy Cart plugin',
		'scwpec_section_text',
		'scwpec'
	);
	add_settings_field('scwpec_host', 'Host:', 'scwpec_host', 'scwpec', 'scwpec_main');
        add_settings_field('scwpec_dbuser', 'DataBase User Name:', 'scwpec_dbuser', 'scwpec', 'scwpec_main');
        add_settings_field('scwpec_dbpassword', 'DataBase Password:', 'scwpec_dbpassword', 'scwpec', 'scwpec_main');
        add_settings_field('scwpec_dbase', 'DataBase Name:', 'scwpec_dbase', 'scwpec', 'scwpec_main');
        add_settings_field('scwpec_tcustomers', 'Customers Table Name:', 'scwpec_tcustomers', 'scwpec', 'scwpec_main');
        add_settings_field('scwpec_torders', 'Orders Table Name:', 'scwpec_torders', 'scwpec', 'scwpec_main');
        
}

// Draw the section header
function scwpec_section_text() {
	echo '<h3>External database settings</h3><p>Only letters, numbers, hyphons and underscores allowed</p>';
}

// Display and fill the form fields
function scwpec_host() {	
	$options = get_option( 'scwpec_options' );
        $host = $options['host'];
        echo "<input id='host' name='scwpec_options[host]' type='text' value='$host' /></br>"; }
function scwpec_dbuser() {	
	$options = get_option( 'scwpec_options' );
        $dbuser = $options['dbuser'];
        echo "<input id='dbuser' name='scwpec_options[dbuser]' type='text' value='$dbuser' /></br>"; }
function scwpec_dbpassword() {	
	$options = get_option( 'scwpec_options' );
        $dbpassword = $options['dbpassword'];
        echo "<input id='dbpassword' name='scwpec_options[dbpassword]' type='password' value='$dbpassword' />"; }
function scwpec_dbase() {	
	$options = get_option( 'scwpec_options' );
        $dbase = $options['dbase'];
        echo "<input id='dbase' name='scwpec_options[dbase]' type='text' value='$dbase' /></br>"; } 
function scwpec_tcustomers() {	
	$options = get_option( 'scwpec_options' );
        $tcustomers = $options['tcustomers'];
        echo "<input id='tcustomers' name='scwpec_options[tcustomers]' type='text' value='$tcustomers' />"; }
function scwpec_torders() {	
	$options = get_option( 'scwpec_options' );
        $torders = $options['torders'];
        echo "<input id='torders' name='scwpec_options[torders]' type='text' value='$torders' />"; }

// Validate user input (we want text only)
function scwpec_validate( $options ) {
    $correct = 1;
    $inputs=['host', 'dbase', 'dbuser', 'tcustomers', 'torders'];
    //Validating input
    foreach ($inputs as $ipt) {
        $valid[$ipt] = preg_replace( '/[^a-zA-Z0-9-_]/', '', $options[$ipt] );
        if( $valid[$ipt] != $options[$ipt] ) {
            add_settings_error(	'scwpec_'.$ipt, 'scwpec_texterror'.$ipt, 'Incorrect value entered: '.$ipt,'error');
            $valid[$ipt] = '';
            $correct = 0;
         }       
        }
    //Validating connection
    if ($correct === 1) { //No problem with input 
        require_once 'includes/dbconnect.php';
            $scb = new dbconnect($options['host'], $options['dbase'], $options['dbuser'], $options['dbpassword']);
            $scbs = $scb->CStatus();
            if (!$scbs) {
                $scbm = $scb->Cmessage();
                add_settings_error('scwpec_host', 'scwpec_texterror', 'Connection failed with input data: '.$scbm,'error');
                $correct = 0;
                }
            else
            { 
                add_settings_error('scwpec_host', 'scwpec_texterror', 'Input data yields a successful connection!!','updated');     
             } 
    $scb->null;
    }
	update_option('scwpec_connected', $correct);
    return $valid;    
        
}





