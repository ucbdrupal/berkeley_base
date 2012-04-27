<?php
/**
 * @file header.tpl.php
 *
 * This is not a "real" template file that interacts with the PHPtemplate 
 * engine, but rather an include file called from page.tpl.php
 *
 * The purpose of this file is to create an easy way for themers to customize
 * their header without editing the entire page.tpl.php file
**/
?>

<div id="header" class="clearfix">

  <?php if ($site_name || $site_slogan || $logo): ?>
    <div id="name-and-slogan" class="clearfix">

      <?php
      /**
       * Recent SEO recommendations suggest "hiding" site names through a
       * negative text-indent is bad practice. Instead, logos should be wrapped
       * with the desired header tags and the alt text should be the site name.
       * Google and screenreaders are both engineered to read the alt text of
       * images, and the headers which wrap those images will give the 
       * alt text the prominence desired.
       * 
       * @see http://luigimontanez.com/2010/stop-using-text-indent-css-trick/
      **/ ?>
      <?php if ($site_name): ?>
        <?php if ($title): ?>
          <div id="site-name">
            <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><?php print $site_name; ?></a>
            <div id="site-name-description"><a href="http://berkeley.edu" title="<?php print t('UC Berkeley'); ?>"><?php print $credits['university_name']; ?></a></div>
          </div>
        <?php else: /* Use h1 when the content title is empty */ ?>
          <h1 id="site-name">
            <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><?php print $site_name; ?></a>
            <div id="site-name-description"><a href="http://berkeley.edu" title="<?php print t('UC Berkeley'); ?>"><?php print $credits['university_name']; ?></a></div>
          </h1>
        <?php endif; ?>
      <?php endif; ?>

    </div>
  <?php endif; ?>
  
  <?php if ($main_menu || $secondary_menu || $search_box || $front_header_text) : ?>
    <div id="menu-and-search" class="clearfix">
      
      <?php if ($front_header_text && $is_front): ?>
        <div id="front-header">
          <div id="front-header-inner">
            <?php if ($front_header_title): ?>
              <h3><?php print $front_header_title; ?></h3>
            <?php endif; ?>
            <p><?php print $front_header_text . ' ' . $front_header_link; ?></p>
          </div>
        </div>
      <?php endif; ?>
      <?php if ($main_menu): ?>
        <div id="navigation" class="menu">
          <?php print theme('links', array('links' => $main_menu, 'attributes' => array('id' => 'primary', 'class' => array('links', 'clearfix', 'main-menu')))); ?>
        </div>
      <?php endif; ?>
      
      <?php if ($secondary_menu): ?>
        <div class="secondary menu">
          <?php print theme('links', array('links' => $secondary_menu, 'attributes' => array('id' => 'secondary', 'class' => array('links', 'clearfix', 'secondary-menu')))); ?>
        </div>
      <?php endif; ?> 
  
      <?php if ($search_box): ?>
        <div id="search">
          <?php print $search_box; ?>
        </div>
      <?php endif; ?>

    </div>
  <?php endif; ?>

  <?php if ($page['header']): ?>
    <div id="header-region">
      <?php print render($page['header']); ?>
    </div>
  <?php endif; ?>

</div> <!-- /header -->
