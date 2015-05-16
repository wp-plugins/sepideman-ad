<?php
/**
 * Plugin Name: تبلیغات سپیدمان
 * Plugin URI: http://plugins.sepideman.com/sepideman-ad
 * Description: افزونه تبلیغات کلیکی سپیدمان برای شبکه تبلیغاتی anetwork
 * Version: 1.0.2
 * Author: زرتشت سپیدمان
 * Author URI: http://www.ZartoshtSepideman.com
 * License: GPLv2
 * Tags: Anetwork, Sepideman, Ads, Advertising, Shortcode, آنتورک, تبلیغات, کلیک, تبلیغات کلیکی, سپیدمان ,کد کوتاه
 */
if ( ! defined( 'ABSPATH' ) ) {die();}

add_action( 'admin_menu', 'sepideman_ad_menu' );
function sepideman_ad_menu(){
	add_menu_page( 'تبلیغات سپیدمان', 'تبلیغات سپیدمان', 'manage_options', 'sepideman-ad', 'sepideman_ad', plugins_url( 'sepideman-ad/images/sepideman_ad.png' ), 7 ); 
	add_submenu_page( 'sepideman-ad', 'تنظیمات تبلیغات سپیدمان', 'تنظیمات', 'manage_options', 'sepideman-ad-settings', 'sepideman_ad_settings');
	add_submenu_page( 'sepideman-ad', 'راهنمای تبلیغات سپیدمان', 'راهنما', 'manage_options', 'sepideman-ad-help', 'sepideman_ad_help');
}

add_action( 'admin_init', 'register_sepideman_ad_settings' );
function register_sepideman_ad_settings(){
	register_setting( 'sp-ad-settings', 'aduser', intval );
}

function jqueri_accordion(){
	wp_enqueue_script( 'jquery-ui-accordion' );
	wp_register_script( 'accordion_script', plugins_url( 'sepideman-ad/js/admin.js' ), array('jquery'),'1', true);
	wp_enqueue_script( 'accordion_script' );
}
add_action( 'admin_enqueue_scripts', 'jqueri_accordion' );

function sepideman_ad() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap"><h2>تبلیغات سپیدمان</h2>';
	echo '<hr>';
	if ( esc_attr(get_option('aduser')) == '' || esc_attr(get_option('aduser')) == 0 ) {
		echo 'لطفا شناسه کاربری خود را از وبسایت <a target="_blank" href="http://anetwork.ir">آنتورک</a> وارد کنید. شناسه کاربری با یوزرنیم ورود به وبسایت تفاوت دارد. برای راهنمایی درباره شناسه کاربری به بخش راهنمای افزونه،';
		echo '<a href="' . site_url() . '/wp-admin/admin.php?page=sepideman-ad-help">اینجا</a> مراجعه کنید.';
		echo 'و اگر شناسه کاربری خود را دریافت کرده‌اید با مراجعه به ';
		echo '<a href="' . site_url() . '/wp-admin/admin.php?page=sepideman-ad-settings">تنظیمات</a>';
		echo ' شناسه خود را وارد کنید.';
	} else {
		echo '<div style="text-align: center;">کد کوتاه: <input id="shortcode" type="text" style="width: 500px; text-align: center; direction: ltr;" onclick="this.setSelectionRange(0, this.value.length)"></div>';
		echo '<div id="accordion">
  <h3 style="background-color: #1ec888; padding: 10px;" onclick="mode(jQuery(\'#basic_ad\').attr(\'name\'))" name="basic" id="basic_ad">تبلیغات ساده</h3>
  <div>
    <p style="text-align: center;">
	<input type="button" value="125x125" onclick="basic(this.value)">
	<input type="button" value="120x240" onclick="basic(this.value)">
	<input type="button" value="160x600" onclick="basic(this.value)">
	<input type="button" value="234x60" onclick="basic(this.value)">
	<input type="button" value="600x300" onclick="basic(this.value)">
	<input type="button" value="468x60" onclick="basic(this.value)">
	<input type="button" value="728x90" onclick="basic(this.value)">
	<input type="button" value="300x250" onclick="basic(this.value)">
	<input type="button" value="120x600" onclick="basic(this.value)">
	<input type="button" value="300x100" onclick="basic(this.value)">
    </p>
  </div>
  <h3 style="background-color: #1ec888; padding: 10px;" onclick="mode(jQuery(\'#static_ad\').attr(\'name\'))" name="static" id="static_ad">تبلیغات ثابت</h3>
  <div>
    <p>
	<table style="width: 100%;">
		<tr>
			<td style="text-align: right; vertical-align: top; height: 50px; height: 50px;">
				<input type="button" value="120x240" onclick="static(this.value, \'rt\')">
				<input type="button" value="125x125" onclick="static(this.value, \'rt\')">
			</td>
			<td style="text-align: left; vertical-align: top; height: 50px;">
				<input type="button" value="120x240" onclick="static(this.value, \'lt\')">
				<input type="button" value="125x125" onclick="static(this.value, \'lt\')">
			</td>
		</tr>
		<tr>
			<td style="text-align: right; vertical-align: bottom; height: 50px;">
				<input type="button" value="120x240" onclick="static(this.value, \'rb\')">
				<input type="button" value="125x125" onclick="static(this.value, \'rb\')">
			</td>
			<td style="text-align: left; vertical-align: bottom; height: 50px;">
				<input type="button" value="120x240" onclick="static(this.value, \'lb\')">
				<input type="button" value="125x125" onclick="static(this.value, \'lb\')">
			</td>
		</tr>
	</table>
    </p>
  </div>
  </div>
  <h3 style="background-color: #1ec888; padding: 10px;" onclick="mode(jQuery(\'#lightbox_ad\').attr(\'name\'));" name="lightbox" id="lightbox_ad">تبلیغات لایت‌باکس</h3>
  <h3 style="background-color: #1ec888; padding: 10px;" onclick="mode(jQuery(\'#scroll_ad\').attr(\'name\'))" name="scroll" id="scroll_ad">تبلیغات اسکرولی</h3>
  <div style="text-align: center">
	<a href="http://www.anetwork.ir" target="_blank"><img src="' . plugins_url( 'sepideman-ad/images/anetwork.png' ) . '"></a>
	<hr><hr>
  </div>
  <div style="text-align: center">
	طراحی و توسعه توسط <a href="http://www.sepideman.com" target="_blank">سپیدمان<img src="' . plugins_url( 'sepideman-ad/images/sepideman-80.png' ) . '"></a>
  </div>
  </div>';
	}
}

function sepideman_ad_settings(){
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap"><h2>تنظیمات تبلیغات سپیدمان</h2>';
	echo '<form method="post" action="options.php">';
	settings_fields( 'sp-ad-settings' );
	do_settings_sections( 'sp-ad-settings' );
	echo '<br><br><table style="width: 100%; height: 50px;"><tr>';
	echo '<td style="width: 10%">شناسه کاربری: </td><td style="width: 90%; height: 50px;"><input dir="ltr" type="text" name="aduser" value="' . esc_attr( get_option('aduser') ) . '"></td></tr>';
	echo '<tr><td colspan="2">';
	echo submit_button();
	echo '</td></tr>';
	echo '</table></form></div>';
}

function sepideman_ad_help(){
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap"><h2>راهنمای پرداخت سپیدمان</h2>';
	echo '<p>برای به دست آوردن شناسه کاربری ابتدا وارد پنل مدیریت خود در وبسایت <a href="http://www.anetwork.ir" target="_blank">آنتورک</a> شوید.</p>';
	echo '<img src="' . plugins_url( 'sepideman-ad/images/help/sepideman-help-01.jpg' ) . '">';
	echo '<p>سپس روی بخش وبسایت های من کلیک کنید. پس از باز شدن منو روی بخش دریافت کد کلیک کنید.</p>';
	echo '<img src="' . plugins_url( 'sepideman-ad/images/help/sepideman-help-02.jpg' ) . '">';
	echo '<p>سپس با انتخاب یکی از موارد دریافت کد ساده، ثابت، لایت باکس و یا اسکرول از یکی از فیلدهای تبلیغ کد را انتخاب کنید.</p>';
	echo '<img src="' . plugins_url( 'sepideman-ad/images/help/sepideman-help-03.jpg' ) . '">';
	echo '<p>در بخش کد تبلیغات پارامتر <code>aduser</code> را پیدا کنید و عدد مقابل آن را کپی کنید.</p>';
	echo '<img src="' . plugins_url( 'sepideman-ad/images/help/sepideman-help-04.jpg' ) . '">';
	echo '<p>این کد، شناسه کاربری شما برای استفاده از افزونه است. این کد را در بخش <a href="' . site_url() . '/wp-admin/admin.php?page=sepideman-ad-settings">تنظیمات</a> وارد و ذخیره کنید.</p>';
	echo '<p>افزونه برای استفاده آماده است.</p><hr><hr>';
	echo '<p>در صورت بروز هرگونه مشکل و انتقاد و پیشنهاد از راه‌های ارتباطی زیر استفاده کنید:</p>
			<div style="text-align: center">
				<a href="http://www.SecuritExperts.com" target="_blank">
					<img src="' . plugins_url( 'sepideman-ad/images/securitexperts-80.png' ) . '" title="وبسایت خبری امنیتی سپیدمان، سکیوریتی اکسپرتز">
				</a>
				<a href="http://www.Sepideman.com" target="_blank">
					<img src="' . plugins_url( 'sepideman-ad/images/sepideman-80.png' ) . '" title="وبسایت رسمی سپیدمان">
				</a>
				<a href="http://www.ZartoshtSepideman.com" target="_blank">
					<img src="' . plugins_url( 'sepideman-ad/images/zartoshtsepideman-80.png' ) . '" title="وبسایت شخصی مدیر عامل سپیدمان">
				</a>
				<a href="https://www.facebook.com/SecuritExperts" target="_blank">
					<img src="' . plugins_url( 'sepideman-ad/images/fb.jpg' ) . '" title="سپیدمان در فیسبوک">
				</a>
				<a href="https://www.instagram.com/SecuritExperts" target="_blank">
					<img src="' . plugins_url( 'sepideman-ad/images/insta.png' ) . '" title="سکیوریتی اکسپرتز در اینستاگرام">
				</a>
				<a href="https://www.instagram.com/Sepideman" target="_blank">
					<img src="' . plugins_url( 'sepideman-ad/images/insta.png' ) . '" title="سپیدمان در اینستاگرام">
				</a>
				<a href="https://www.twitter.com/SecuritExperts" target="_blank">
					<img src="' . plugins_url( 'sepideman-ad/images/twitter.jpg' ) . '" title="سپیدمان در توییتر">
				</a>
			</div>';
	echo '</div>';
}

function wpb_adding_scripts() {
	wp_register_script('static_script', '//static-cdn.anetwork.ir/showad/aw-apfbc.js', array('jquery'),'0.12', true);
	wp_enqueue_script('static_script');
}
add_action( 'wp_enqueue_scripts', 'wpb_adding_scripts' );

add_shortcode( 'sepideman_ad', 'sepideman_ad_show' );
function sepideman_ad_show($atts){
	$atts = shortcode_atts( array(
		'mode' => 'basic',
		'size' => '125x125',
		'pos' => 'lt',
	), $atts, 'sepideman_ad' );
	
	$size = explode( 'x', $atts['size'] );
	$width = $size[0];
	$height = $size[1];
	$position = $atts['pos'];
	
	switch ( $atts['mode'] ){
		case 'basic':
			$result = '<script type="text/javascript">var anetwork_pram = anetwork_pram || [];anetwork_pram["aduser"] = "' . esc_attr( get_option('aduser') ) . '";anetwork_pram["adheight"] = "' . $height . '";anetwork_pram["adwidth"] = "' . $width . '";</script><script type="text/javascript" src="http://static-cdn.anetwork.ir/showad/pub.js"></script>';
			break;
		case 'static':
			$result = '<div class="anetwork-xfb-120-125-main" style="position: fixed; z-index: 99999999;';
							if ($position == 'lt'){ $result .= 'top: 4px; left: 4px;'; }
							if ($position == 'rt'){ $result .= 'top: 4px; right: 4px;'; }
							if ($position == 'rb'){ $result .= 'bottom: 4px; right: 4px;'; }
							if ($position == 'lb'){ $result .= 'bottom: 4px; left: 4px;'; }
			$result .= 'display: none" id="anetwork-xfb-120-' . $position . '">
							<div class="anetwork-xfb-120-125-title" onClick="document.getElementById(\'anetwork-xfb-120-' . $position . '\').style.display = \'none\'; setCookie(\'anetwork-xfb-120-' . $position . '\', 1)">
								<span class="anetwork-xfb-120-125-close">×</span> بستـن تبلـیــغ
							</div>';
			$result .= '<script type="text/javascript">var anetwork_pram = anetwork_pram || [];anetwork_pram[\'aduser\'] = \'' . esc_attr( get_option('aduser') ) . '\'; anetwork_pram[\'adheight\'] = \'' . $height . '\'; anetwork_pram[\'adwidth\'] = \'' . $width . '\';</script> 
							<script type="text/javascript" src="http://static-cdn.anetwork.ir/showad/pub.js"></script>
							</div>';
			break;
		case 'lightbox':
			echo '<script> var _AWLTBX_user = ' . esc_attr( get_option('aduser') ) . '; </script>';
			function run_lightbox(){
				add_action( 'wp_enqueue_scripts', 'wpb_adding_scripts_lightbox' );
			}
			function wpb_adding_scripts_lightbox() {
				wp_register_script('lightbox_script', '//static-cdn.anetwork.ir/showad/aw-ltbx.js', array('jquery'),'0.1', true);
				wp_enqueue_script('lightbox_script');
				return run_lightbox();
			}
			return wpb_adding_scripts_lightbox();
			break;
		case 'scroll':
			echo '<script> var _AWFLT_user = ' . esc_attr( get_option('aduser') ) . '; </script>';
			echo '<script src="http://static-cdn.anetwork.ir/showad/aw-flt.js?v=0.1"></script>';
			break;
	}
	
	return $result;
}
?>