<?php

/**
 * Implementation of hook_form_system_theme_settings_alter() 
 */
function berkeley_base_form_system_theme_settings_alter(&$form, $form_state) {

  // Upaate the "Toogle Display" to something clearer
  $form['theme_settings']['#title'] = t('Theme Display Settings');

  // Change Weighting of Default Setting Fields
  $form['theme_settings']['#weight'] = 20;
  $form['logo']['#weight'] = 30;
  $form['favicon']['#weight'] = 40;

  // Remove the standard logo
  $form['logo']['default_logo']['#access'] = FALSE;
  
  // 'logo_path', 'logo_upload' keys need to be defined so that ucb open academy install won't complain.
  $form['logo']['settings']['logo_path'] = array(
      '#type' => 'textfield',
      '#title' => t('Path to custom logo'),
      '#description' => t('The path to the file you would like to use as your logo file instead of the default logo.'),
      '#default_value' => theme_get_setting('logo_path', 'berkeley_base'),
    );
  $form['logo']['settings']['logo_upload'] = array(
      '#type' => 'file',
      '#title' => t('Upload logo image'),
      '#maxlength' => 40,
      '#description' => t("If you don't have direct file access to the server, use this field to upload your logo.")
    );
  // Hide the logo settings section
  $form['logo']['settings']['#access'] = FALSE;


  // favicon array keys need to be defined so that ucb open academy install won't complain.
  $form['favicon']['settings']['favicon_path'] = array(
      '#type' => 'textfield',
      '#title' => t('Path to custom icon'),
      '#description' => t('The path to the image file you would like to use as your custom shortcut icon.'),
      '#default_value' => theme_get_setting('favicon_path', 'berkeley_base'),
    );
  $form['favicon']['settings']['favicon_upload'] = array(
      '#type' => 'file',
      '#title' => t('Upload icon image'),
      '#description' => t("If you don't have direct file access to the server, use this field to upload your shortcut icon.")
    );

  
  // Define the university information fieldset
  $form['university_info'] = array(
    '#type' => 'fieldset',
    '#title' => t('University Information in Footer'),
  );

  // Define the university name
  $form['university_info']['university_name'] = array(
    '#type' => 'textfield',
    '#title' => t('University Name'),
    '#default_value' => (theme_get_setting('university_name')) ? theme_get_setting('university_name') : t('University of California, Berkeley'),
  );

  // Define the university copyright
  $form['university_info']['university_copyright'] = array(
    '#type' => 'textfield',
    '#title' => t('University Copyright'),
    '#default_value' => (theme_get_setting('university_copyright')) ? theme_get_setting('university_copyright') : t('UC Regents. All rights reserved.'),
  );

  // Define the front page text
  $form['front_header'] = array(
    '#type' => 'fieldset',
    '#title' => t('Callout Information in Header'),
  );

  // Define the front page header title
  $form['front_header']['front_header_title'] = array(
    '#title' => t('Header Title'),
    '#type' => 'textfield',
    '#default_value' => theme_get_setting('front_header_title'),
  );

  // Define the front page header text
  $form['front_header']['front_header_text'] = array(
    '#title' => t('Header Text'),
    '#type' => 'textarea',
    '#rows' => 3,
    '#default_value' => theme_get_setting('front_header_text'),
  );

  // Define the front page header link
  $form['front_header']['front_header_link'] = array(
    '#title' => t('Header Learn More Link'),
    '#type' => 'textfield',
    '#default_value' => theme_get_setting('front_header_link'),
  );

  // Define the social media links
  $form['social_media'] = array(
    '#type' => 'fieldset',
    '#title' => t('Social Media Links in Footer'),
  );

  // Define the twitter link
  $form['social_media']['twitter_link'] = array(
    '#type' => 'textfield',
    '#title' => 'Twitter',
    '#default_value' => theme_get_setting('twitter_link'),
  );

  // Define the facebook link
  $form['social_media']['facebook_link'] = array(
    '#type' => 'textfield',
    '#title' => 'Facebook',
    '#default_value' => theme_get_setting('facebook_link'),
  );

  // Define the youtube link
  $form['social_media']['youtube_link'] = array(
    '#type' => 'textfield',
    '#title' => 'YouTube',
    '#default_value' => theme_get_setting('youtube_link'),
  );

  // Update the image settings to include seal
  $form['logo']['#title'] = 'Image settings';
  $default_seal = theme_get_setting('default_seal');
  $form['logo']['default_seal'] = array(
    '#type' => 'checkbox',
    '#title' => t('Use the default seal'), 
    '#tree' => FALSE,
    '#description' => t('Check here if you want the theme to use the seal supplied with it'),
    '#default_value' => (empty($default_seal)) ? 1 : $default_seal,
  );
  $seal_path = theme_get_setting('seal_path');
  // If $seal_path is a public:// URI, display the path relative to the files
  // directory; stream wrappers are not end-user friendly.
  if (file_uri_scheme($seal_path) == 'public') {
    $seal_path = file_uri_target($seal_path);
  }
  $form['logo']['seal_settings'] = array(
    '#type' => 'container',
    '#states' => array(
      'invisible' => array(
        'input[name="default_seal"]' => array(
          'checked' => TRUE,
        ),
      ),
    ),
    'seal_path' => array(
      '#type' => 'textfield',
      '#title' => 'Path to custom seal',
      '#default_value' => '',
      '#description' => 'The path to the file you would like to use as your seal file instead of the default seal.',
      '#default_value' => $seal_path,
    ),
    'seal_upload' => array(
      '#type' => 'file',
      '#title' => 'Upload logo image',
      '#maxlength' => 40,
      '#description' => 'If you don\'t have direct file access to the server, use this field to upload your seal.',
    ),
  );
  
  
  $form['#submit'][] = 'berkeley_base_theme_settings_submit';
  $form['#validate'][] = 'berkeley_base_theme_settings_validate';
}

/**
 * Custom Validation Hook
 */
function berkeley_base_theme_settings_validate($form, &$form_state) {
  // Handle file uploads.
  $validators = array('file_validate_is_image' => array());

  // Check for a new uploaded logo.
  $file = file_save_upload('seal_upload', $validators);
  if (isset($file)) {
    // File upload was attempted.
    if ($file) {
      // Put the temporary file in form_values so we can save it on submit.
      $form_state['values']['seal_upload'] = $file;
    }
    else {
      // File upload failed.
      form_set_error('seal_upload', t('The seal could not be uploaded.'));
    }
  }

  // If the user provided a path for a seal file, make sure a file
  // exists at that path.
  if ($form_state['values']['seal_path']) {
    $path = _system_theme_settings_validate_path($form_state['values']['seal_path']);
    if (!$path) {
      form_set_error('seal_path', t('The custom seal path is invalid.'));
    }
  }
  
  //install profile will complain if logo_path is not in the form
  if (!isset($form['logo_path'])) {
    $form['logo_path'] = '';
  } 

}

/**
 * Custom Submit Hook
 */
function berkeley_base_theme_settings_submit($form, &$form_state) {
  $values = $form_state['values'];

  // If the user uploaded a new seal, save it to a permanent location
  // and use it in place of the default theme-provided file.
  if ($file = $values['seal_upload']) {
    unset($values['seal_upload']);
    $filename = file_unmanaged_copy($file->uri);
    $values['default_seal'] = 0;
    $values['seal_path'] = $filename;
    $values['toggle_seal'] = 1;
  }

  // If the user entered a path relative to the system files directory for
  // a seal, store a public:// URI so the theme system can handle it.
  if (!empty($values['seal_path'])) {
    $values['seal_path'] = _system_theme_settings_validate_path($values['seal_path']);
  }

  // Save the values to $form_state
  if (!empty($values['seal_path'])) {
    $form_state['values']['seal_path'] = $values['seal_path'];
  }
  if (!empty($values['toggle_seal'])) {
    $form_state['values']['toggle_seal'] = $values['toggle_seal'];
  }
  $form_state['values']['default_seal'] = $values['default_seal'];
}
