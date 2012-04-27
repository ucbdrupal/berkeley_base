<?php
$plugin = array(
  'title' => t('Berkeley Blue Header'),
  'description' => t('Wraps panes in the Berkeley blue style.'),
  'render pane' => 'berkeley_blue_render_pane',
  'weight' => -10,
);

/**
 * Theme function for the pane style.
 */
function theme_berkeley_blue_render_pane($vars) {
  $content = $vars['content'];
  $pane = $vars['pane'];
  $display = $vars['display'];
  $plugin = $vars['style'];
  
  $content->css_class .= ' pane-berkeley-blue';
  
  // if the style is gone or has no theme of its own, just display the output.
  return theme('panels_pane', array('content' => $content, 'pane' => $pane, 'display' => $display));
}
