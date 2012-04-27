<?php
/**
 * @file footer.tpl.php
 *
 * This is not a "real" template file that interacts with the PHPtemplate 
 * engine, but rather an include file called from page.tpl.php
 *
 * The purpose of this file is to create an easy way for themers to customize
 * their footer without editing the entire page.tpl.php file
**/
?>

<?php if (isset($footer_menu) || $contact_information || $social_links || $seal || $page['footer']): ?>
  <div id="footer" class="clearfix">
    
    <div id="footer-content" class="clearfix">
      <?php print render($page['footer']); ?>
  
      <?php if ($social_links): ?>
        <div id="social-profile-links" class="clearfix">
          <?php print $social_links; ?>
        </div>
      <?php endif; ?>
  
      <?php if (isset($footer_menu) || $social_links): ?>
        <div id="menu-and-social">
  
          <?php if (isset($footer_menu)): ?>
            <div class="footer menu">
              <?php print theme('links', array('links' => $footer_menu, 'attributes' => array('id' => 'footer-menu', 'class' => array('links', 'clearfix', 'footer-menu')))); ?>
            </div>
          <?php endif; ?>
          
          <?php if ($social_media_buttons_rendered): ?>
            <div id="social-media-buttons" class="clearfix">
              <?php print $social_media_buttons_rendered; ?>
            </div>
          <?php endif; ?>
          
       </div>
      <?php endif; ?>
    </div><!-- /#footer-content -->
    
    <div id="footer-footer" class="clearfix">
      <?php if ($seal || $credits['university_name'] || $credits['copyright']): ?>
        <div id="seal-and-contact">
          <?php if ($seal): ?>
            <div id="footer-seal">
              <a href="http://berkeley.edu" title="<?php print t('UC Berkeley'); ?>" id="seal">
                <img src="<?php print $seal; ?>" alt="<?php print ($site_name ? $site_name . ' ' . t('Seal') : t('Home')); ?>" />
              </a>
            </div>
          <?php endif; ?>
          
          <?php if ($credits['university_name']): ?>
            <div id="footer-university-name">
              <a href="http://berkeley.edu" title="<?php print t('UC Berkeley'); ?>"><?php print $credits['university_name']; ?></a>
            </div>
          <?php endif; ?>
          
          <?php if ($credits['copyright']): ?>
            <div id="footer-copyright">
               <?php print $credits['copyright']; ?>
            </div>
          <?php endif; ?>
  
       </div><!-- /#seal-and-contact -->
      <?php endif; ?>
    </div><!-- /#footer-footer -->

  </div><!-- /footer -->
<?php endif; ?>
