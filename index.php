<?php
/*
Plugin Name: Buddypress Market Places
Plugin URI: https://github.com/enishant/marketplaces
Description: Marketplaces plugin can be used with Buddypress and BePro Listings for displaying BePro Listings categories as marketplaces on page with shortcode.
Tags: buddypress,bepro,listing,marketplaces,business, business-directory, catalogue, classifieds, directory,members, real estate
Version: 1.1
Author: Nishant Vaity
Author URI: https://github.com/enishant
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
function bp_get_categories() { 
	$args = array(
	'post_type' => 'bepro_listings',
	'show_option_all'    => '',
	'orderby'            => 'name',
	'order'              => 'ASC',
	'style'              => '',
	'show_count'         => 1,
	'hide_empty'         => 0,
	'use_desc_for_title' => 1,
	'child_of'           => 0,
	'number'             => null,
	'echo'               => 0,
	'taxonomy'           => 'bepro_listing_types',
	'walker'             => null
	);
	$categories = get_categories( $args );
	$cat_display_count = 1;
	$cat_col_one = array();
	$cat_col_two = array();
	$cat_col_three = array();
	foreach ( $categories as $category )
	{
		if(!$category->category_parent > 0)
		{
			$category_data = '<li><a href="' . get_category_link($category) . '">' . $category->name . '</a> (' . $category->count .')</li>';
		}
		if($cat_display_count == 1)
		{
			$cat_col_one[] = $category_data;
		}
		if($cat_display_count == 2)
		{
			$cat_col_two[] = $category_data;
		}
		if($cat_display_count == 3)
		{
			$cat_col_three[] = $category_data;
		}	
		if($cat_display_count<3)
		{
			$cat_display_count++;
		}
		else
		{
			$cat_display_count = 1;
		}
	}
	$marketplaces .= '<div class="marketplaces">';	
		
		$marketplaces .= '<div class="marketplace_one">';
		$marketplaces .= '<ul class="one">';
			foreach($cat_col_one as $one)
			{
				$marketplaces .= $one;
			}
		$marketplaces .= '</ul>';			
		$marketplaces .= '</div>';
		
		$marketplaces .= '<div class="marketplace_two">';
		$marketplaces .= '<ul class="two">';		
			foreach($cat_col_two as $two)
			{
				$marketplaces .= $two;
			}
		$marketplaces .= '</ul>';			
		$marketplaces .= '</div>';
		
		$marketplaces .= '<div class="marketplace_three">';
		$marketplaces .= '<ul class="three">';		
			foreach($cat_col_three as $three)
			{
				$marketplaces .= $three;
			}
		$marketplaces .= '</ul>';
		$marketplaces .= '</div>';
		
		$marketplaces .= '<div style="clear:both;"></div>';
	$marketplaces .= '</div>';
	$marketplaces .= '<style type="text/css">';
	$marketplaces .= '.marketplaces .marketplace_one,';
	$marketplaces .= '.marketplaces .marketplace_two,';
	$marketplaces .= '.marketplaces .marketplace_three {width:245px;float:left;}';
	$marketplaces .= '.marketplaces ul li{list-style:none;padding-top:10px;}';
	$marketplaces .= '</style>';
	return $marketplaces;
}
add_shortcode('marketplaces','bp_get_categories');

function send_email_on_plugin_activate() {
	$plugin_title = "Marketplaces";
	$plugin_url = 'https://wordpress.org/plugins/marketplaces/';
	$plugin_support_url = 'http://wordpress.org/support/plugin/marketplaces';
	$plugin_author = 'Nishant Vaity';
	$plugin_author_url = 'https://github.com/enishant';
	$plugin_author_mail = 'enishant@gmail.com';

	$website_name  = get_option('blogname');
	$adminemail = get_option('admin_email');
	$user = get_user_by( 'email', $adminemail );

	$headers = 'From: ' . $website_name . ' <' . $adminemail . '>' . "\r\n";
	$subject = "Thank you for installing " . $plugin_title . "!\n";
	if($user->first_name)
	{
		$message = "Dear " . $user->first_name . ",\n\n";
	}
	else
	{
		$message = "Dear Administrator,\n\n";
	}
	$message.= "Thank your for installing " . $plugin_title . " plugin.\n";
	$message.= "Visit this plugin's site at " . $plugin_url . " \n\n";
	$message.= "Please write your queries and suggestions at developers support \n" . $plugin_support_url ."\n";
	$message.= "All the best !\n\n";
	$message.= "Thanks & Regards,\n";
	$message.= $plugin_author . "\n";
	$message.= $plugin_author_url ;
	wp_mail( $adminemail, $subject, $message,$headers);
	
	$subject = $plugin_title . " plugin is installed and activated by website " . get_option('home') ."\n";
	$message = $plugin_title  . " plugin is installed and activated by website " . get_option('home') ."\n\n";
	$message.= "Website : " . get_option('home') . "\n";
	$message.="Email : " . $adminemail . "\n";
	if($user->first_name)
	{
		$message.= "First name : " . $user->first_name . " \n";
	}
	if($user->last_name)
	{
		$message.= "Last name : " . $user->last_name . "\n";	
	}
	wp_mail( $plugin_author_mail , $subject, $message,$headers);
}
register_activation_hook( __FILE__, 'send_email_on_plugin_activate' );
?>
