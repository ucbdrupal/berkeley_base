<?php
$plugin = array(
  'title' => t('Berkeley Gold Header'),
  'description' => t('Wraps panes in the Berkeley Gold header style.'),
  'render pane' => 'berkeley_gold_render_pane',
  'weight' => -10,
);

/**
 * Theme function for the pane style.
 */
function theme_berkeley_gold_render_pane($vars) {
  $content = $vars['content'];
  $pane = $vars['pane'];
  $display = $vars['display'];
  $plugin = $vars['style'];
  
  $content->css_class .= ' pane-berkeley-gold';
  
  // if the style is gone or has no theme of its own, just display the output.
  return theme('panels_pane', array('content' => $content, 'pane' => $pane, 'display' => $display));
}
