<?php

function berkeley_base_preprocess_page(&$vars, $hook) {

  // Setup the Search Box
  $search_box_form = drupal_get_form('search_form');
  $search_box_form['basic']['keys']['#title'] = '';
  $search_box_form['basic']['keys']['#attributes'] = array('placeholder' => 'Search');
  $search_box_form['basic']['submit']['#value'] = t('Go');
  $search_box = drupal_render($search_box_form);
  $vars['search_box'] = (user_access('search content')) ? $search_box : NULL;

  // Setup the social links for the site
  // Note - this theme also supports "google", "linkedin", "foursquare", "digg", "delicious", and "flickr" which
  // can be added here directly or through the theme-settings file
  $social_links = array();
  if ($twitter_link = theme_get_setting('twitter_link')) {
    $social_links[] = '<span class="social-profile-wrapper-twitter">' . l('Twitter', $twitter_link, array('attributes' => array('class' => 'social-profile-link-twitter'))) . '</span>';
  }
  if ($facebook_link = theme_get_setting('facebook_link')) {
    $social_links[] = '<span class="social-profile-wrapper-facebook">' . l('Facebook', $facebook_link, array('attributes' => array('class' => 'social-profile-link-facebook'))) . '</span>';
  }
  if ($youtube_link = theme_get_setting('youtube_link')) {
    $social_links[] = '<span class="social-profile-wrapper-youtube">' . l('YouTube', $youtube_link, array('attributes' => array('class' => 'social-profile-link-youtube'))) . '</span>';
  }
  $vars['social_links'] = (count($social_links)) ? theme('item_list', array('items' => $social_links, 'title' => t('Follow us on your favorite network'))) : NULL;

  // Setup the about text
  $vars['front_header_title'] = theme_get_setting('front_header_title');
  $vars['front_header_text'] = _filter_autop(theme_get_setting('front_header_text'));
  $vars['front_header_link'] = l('Learn more!', theme_get_setting('front_header_link'), array('external' => TRUE));

  // Footer credits
  $vars['credits']['university_name'] = theme_get_setting('university_name');
  $vars['credits']['copyright'] = '&copy; ' . theme_get_setting('university_copyright');

  // Define the university seal 
  if (theme_get_setting('seal_path') && !theme_get_setting('default_seal')) {
    $seal_path = theme_get_setting('seal_path');
    $vars['seal'] = file_create_url($seal_path);
  }
  else {
    $vars['seal'] = '/' . path_to_theme() . '/images/seal.jpg';
  }

  // Create social media buttons
  $vars['social_media_buttons'] = array(
    'google' => '<!-- Place this tag where you want the +1 button to render -->
                 <div style="height: 20px; overflow: hidden"><g:plusone size="medium"></g:plusone></div>
                 <!-- Place this render call where appropriate -->
                 <script type="text/javascript">(function() {
                   var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
                   po.src = \'https://apis.google.com/js/plusone.js\';
                   var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
                 })();</script>',
    'twitter' => '<a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
                  <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>',
    'facebook' => '<iframe src="//www.facebook.com/plugins/like.php?href&amp;send=false&amp;layout=button_count&amp;width=55&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:55px; height:21px;" allowTransparency="true"></iframe>',
  );
  if ($vars['social_media_buttons'] && is_array($vars['social_media_buttons'])) {
    $links = array();
    foreach ($vars['social_media_buttons'] as $key => $value) {
      if ($value != '') {
        $links[] = '<span class="social-button-wrapper-' . $key . '">' . $value . '</span>';
      }
    }
    $vars['social_media_buttons_rendered'] = theme('item_list', array('items' => $links));
  }
}

/**
 * Duplicate of theme_menu_local_tasks() but adds clearfix to tabs.
 */
function berkeley_base_menu_local_tasks(&$vars) {  
  $output = '';
  if (!empty($vars['primary'])) {
    $vars['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
    $vars['primary']['#prefix'] .= '<ul class="tabs primary clearfix">';
    $vars['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($vars['primary']);
  }
  if (!empty($vars['secondary'])) {
    $vars['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
    $vars['secondary']['#prefix'] .= '<ul class="tabs secondary clearfix">';
    $vars['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($vars['secondary']);
  }
  return $output;
}
