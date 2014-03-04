<?php
/*
Plugin Name: Buddypress Market Places
Plugin URI: http://www.gravatar.com/enishant
Description: Buddypress Market Places with BePro Listings plugin. Shortcode [marketplaces] to display marketplaces on page.
Tags: buddypress,marketplaces,BePro Listings
Version: 1.0
Author: Nishant Vaity
Author URI: http://www.gravatar.com/enishant
License: GPL2
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
		$category_data = '<li><a href="' . get_category_link($category) . '">' . $category->name . '</a> (' . $category->count .')</li>';
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
?>