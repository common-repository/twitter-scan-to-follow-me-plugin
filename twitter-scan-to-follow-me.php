<?php
/*
Plugin Name: Twitter Scan To Follow Me Plugin
Plugin URI: http://www.twithut.com
Description: Twitter Scan to Follow Me enable your website & blog with QR Code display dynamically generated from your Twitter profile. Your readers can scan with any QR Code reader available for iPhone, Android phones and any smartphones that support QR Reader application to follow you. It remove all hassles to type your Twitter url profile and mouse click.
Version: 1.0
Author: Sunento Agustiar Wu
Author URI: http://www.twithut.com
License: GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/



define("twitter_scan_to_follow_me","1.0",false);

function twitter_scan_to_follow_me_url( $path = '' ) {
	global $wp_version;
	if ( version_compare( $wp_version, '2.8', '<' ) ) { 
		$folder = dirname( plugin_basename( __FILE__ ) );
		if ( '.' != $folder )
			$path = path_join( ltrim( $folder, '/' ), $path );

		return plugins_url( $path );
	}
	return plugins_url( $path, __FILE__ );
}

function activate_twitter_scan_to_follow_me() {
	global $twitter_scan_to_follow_me_options;
	$twitter_scan_to_follow_me_options = array('position_button'=>'after',
							   'style'=>'222', 
							   'username'=>'twithut', 
							   'own_css'=>'float: right;');
	add_option('twitter_scan_to_follow_me_options',$twitter_scan_to_follow_me_options);
}	

global $twitter_scan_to_follow_me_options;	

$twitter_scan_to_follow_me_options = get_option('twitter_scan_to_follow_me_options');		
	  
register_activation_hook( __FILE__, 'activate_twitter_scan_to_follow_me' );

function add_twitter_scan_to_follow_me_automatic($content){ 
 global $twitter_scan_to_follow_me_options, $post;
 
 $p_title = get_the_title($post->ID);
 $postUrl = get_permalink( $post->ID ).'&title='.str_replace(' ','+',$p_title).'&referenceUrl='.get_bloginfo( 'url' );
 $style = $twitter_scan_to_follow_me_options['style'];
 $username = $twitter_scan_to_follow_me_options['username'];
 $own_css = $twitter_scan_to_follow_me_options['own_css'];

	$htmlCode = "<div style=\"$own_css\">";
	$htmlCode .= '<a href="http://twithut.com/follow/' . $username . '" title="Scan ' . $username . ' to follow with QR Scanner (Powered by : TwitHut.com)"><img src="http://www.twithut.com/twitsigs/' . $style . '/' . $username . '.png' .   '" border=0></a>';
	$htmlCode .= "</div>";
		
	$twitter_scan_to_follow_me = $htmlCode;
	if($twitter_scan_to_follow_me_options['position_button'] == 'before' ){
		$content = $twitter_scan_to_follow_me . $content;
	}
	else if($twitter_scan_to_follow_me_options['position_button'] == 'after' ){
		$content = $content . $twitter_scan_to_follow_me;
	} else  if($twitter_scan_to_follow_me_options['position_button'] == 'before_and_after' ){
		$content = $twitter_scan_to_follow_me. $content. $twitter_scan_to_follow_me;
	}
	return $content;
}

if ($twitter_scan_to_follow_me_options['position_button'] != 'manual'){
	add_filter('the_content','add_twitter_scan_to_follow_me_automatic'); 
}

function add_twitter_scan_to_follow_me(){
	global $twitter_scan_to_follow_me_options, $post;
	
	$p_title = get_the_title($post->ID);
	$postUrl = get_permalink( $post->ID ).'&title='.str_replace(' ','+',$p_title).'&referenceUrl='.get_bloginfo( 'url' );
	$style = $twitter_scan_to_follow_me_options['style'];
	$username = $twitter_scan_to_follow_me_options['username'];
	$own_css = $twitter_scan_to_follow_me_options['own_css'];
	
	$htmlCode = "<div style=\"$own_css\">";
	$htmlCode .= '<a href="http://twithut.com/follow/' . $username . '" title="Scan ' . $username . ' to follow with QR Scanner (Powered by : TwitHut.com)"><img src="http://www.twithut.com/twitsigs/' . $style . '/' . $username . '.png' .   '" border=0></a>';
	$htmlCode .= "</div>";

	$twitter_scan_to_follow_me = $htmlCode;

	echo $twitter_scan_to_follow_me;
}

// function for adding settings page to wp-admin
function twitter_scan_to_follow_me_settings() {
	add_options_page('Scan To Follow Me', 'Scan To Follow Me', 9, basename(__FILE__), 'twitter_scan_to_follow_me_options_form');
}

function twitter_scan_to_follow_me_options_form(){ 
	global $twitter_scan_to_follow_me_options;
?>

<div class="wrap">

<div id="poststuff" class="metabox-holder has-right-sidebar" style="float:right;width:30%;"> 
   <div id="side-info-column" class="inner-sidebar"> 
			<div class="postbox"> 
			  <h3 class="hndle"><span>About this Plugin:</span></h3> 
			  <div class="inside">
                <ul>
					<li><a href="http://www.twithut.com" title="Visit TwitHut.com, learn all the benefits you can have with Twitter Signatures" >TwitHut.com</a></li>
					<li><a href="http://www.twithut.com/component/jtwit/?task=plan_comparison" title="Earn Money by just showing your QR Code ?" >Enable Your Own Ad (AdSense, Chitika, Adbrite) with This Plugin</a></li>
					<li><a href="http://www.twithut.com/halloffame" title="Hall Of Fame - Vote for yours">Hall Of Fame</a></li>					
                </ul> 
              </div> 
			</div> 
     </div>
 </div> <!--end of poststuff --> 


<form method="post" action="options.php">

<?php settings_fields('twitter_scan_to_follow_me_options_group'); ?>

<h2>Scan To Follow Me Options</h2> 
<p style="text-align:left;">Please visit <a href="http://www.twithut.com" target="_blank">TwitHut.com </a> and activate your free account with Twitter OAuth before you start using this plugin. You do not have to register with us (optional)</p>
<table class="form-table" style="clear:none;width:70%;">


<tr valign="top">
<th scope="row">Twitter Username:</th>
<td><input id="own_css" name="twitter_scan_to_follow_me_options[username]" value="<?php echo $twitter_scan_to_follow_me_options['username']; ?>"></td>
</td>
</tr>

<tr valign="top">
<th scope="row">QR Code Style</th>
<td>
<select name="twitter_scan_to_follow_me_options[style]" id="style" >
	<option value="222" <?php if ($twitter_scan_to_follow_me_options['style'] == "222"){ echo "selected";}?> >Twitter URL (Free)</option>
	<option value="221" <?php if ($twitter_scan_to_follow_me_options['style'] == "221"){ echo "selected";}?>>Latest Twit (Premium)</option>	
</select>
</td>
</tr>

<tr valign="top">
<th scope="row">QR Code Display Location:</th>
<td><select name="twitter_scan_to_follow_me_options[position_button]" id="position_button" >
<option value="before" <?php if ($twitter_scan_to_follow_me_options['position_button'] == "before"){ echo "selected";}?> >Before Content</option>
<option value="after" <?php if ($twitter_scan_to_follow_me_options['position_button'] == "after"){ echo "selected";}?> >After Content</option>
<option value="before_and_after" <?php if ($twitter_scan_to_follow_me_options['position_button'] == "before_and_after"){ echo "selected";}?> >Before and After</option>
<option value="manual" <?php if ($twitter_scan_to_follow_me_options['position_button'] == "manual"){ echo "selected";}?> >Manual Insertion</option>
</select><br/>
<b>Note:</b> &nbsp;You can also use this tag <code>add_twitter_scan_to_follow_me();</code> for manually insert button to any of your post item.
</td>
</tr>


<tr valign="top">
<th scope="row">Custom CSS for &lt;div&gt; (i.e. float: right;):</th>
<td><input id="own_css" name="twitter_scan_to_follow_me_options[own_css]" value="<?php echo $twitter_scan_to_follow_me_options['own_css']; ?>"></td>
</td>
</tr>

</table>

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save') ?>" />
</p>

</form>

</div>
<?php }

// Hook for adding admin menus
if ( is_admin() ){ // admin actions
  add_action('admin_menu', 'twitter_scan_to_follow_me_settings');
  add_action( 'admin_init', 'register_twitter_scan_to_follow_me_settings' ); 
} 
function register_twitter_scan_to_follow_me_settings() { // whitelist options
  register_setting( 'twitter_scan_to_follow_me_options_group', 'twitter_scan_to_follow_me_options' );
}

?>