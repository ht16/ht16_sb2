<?php
// $Id $

require_once("common_methods.php");

function get_full_path_to_theme() {
  return base_path().path_to_theme();
}

/**
 * Generate the HTML output for a single local task link.
 *
 * @ingroup themeable
 */
function wilderness_menu_local_task($link, $active = FALSE) {
  $output = preg_replace('~<a href="([^"]*)"[^>]*>([^<]*)</a>~',
  '<a href="$1" class="Button">'
  .'<span class="btn">'
  .'<span class="l"></span>'
  .'<span class="r"></span>'
  .'<span class="t">$2</span>'
  .'</span>'
  .'</a>', $link);
  return $output;
}

/**
 * Returns the rendered local tasks. The default implementation renders them as tabs.
 *
 * @ingroup themeable
 */
function wilderness_menu_local_tasks() {
  $output = '';

  if ($primary = menu_primary_local_tasks()) {
    $output .= $primary;
  }
  if ($secondary = menu_secondary_local_tasks()) {
    $output .= $secondary;
  }
  return $output;
}

/**
 * Theme a form button.
 *
 * @ingroup themeable
 */
function ht16_sb2_button($element) {
  // Make sure not to overwrite classes.
  if (isset($element['#attributes']['class'])) {
    $element['#attributes']['class'] = 'Button form-' . $element['#button_type'] . ' ' . $element['#attributes']['class'];
  }
  else {
    $element['#attributes']['class'] = 'Button form-' . $element['#button_type'];
  }

  // Skip admin pages due to some issues with ajax looking for <input> not <button>.
  if (arg(0) == 'admin') {
    return '<input type="submit" '. (empty($element['#name']) ? '' : 'name="'. $element['#name'] .'" ') .'id="'. $element['#id'] .'" value="'. check_plain($element['#value']) .'" '. drupal_attributes($element['#attributes']) ." />\n";
  }

  return '<button type="submit" ' . (empty($element['#name']) ? '' : 'name="' . $element['#name']
         . '" ')  . 'id="' . $element['#id'] . '" value="' . check_plain($element['#value']) . '" ' . drupal_attributes($element['#attributes']) . '>'
         . '<span class="btn">'
         . '<span class="l"></span>'
         . '<span class="r"></span>'
         . '<span class="t">' . check_plain($element['#value']) . '</span>'
         . '</span></button>';
}

/**
 * Image assist module support.
 * Using Artisteer styles in IE
*/
function ht16_sb2_img_assist_page($content, $attributes = NULL) {
  $title = drupal_get_title();
  $output = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
  $output .= '<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">'."\n";
  $output .= "<head>\n";
  $output .= '<title>'. $title ."</title>\n";

  // Note on CSS files from Benjamin Shell:
  // Stylesheets are a problem with image assist. Image assist works great as a
  // TinyMCE plugin, so I want it to LOOK like a TinyMCE plugin. However, it's
  // not always a TinyMCE plugin, so then it should like a themed Drupal page.
  // Advanced users will be able to customize everything, even TinyMCE, so I'm
  // more concerned about everyone else. TinyMCE looks great out-of-the-box so I
  // want image assist to look great as well. My solution to this problem is as
  // follows:
  // If this image assist window was loaded from TinyMCE, then include the
  // TinyMCE popups_css file (configurable with the initialization string on the
  // page that loaded TinyMCE). Otherwise, load drupal.css and the theme's
  // styles. This still leaves out sites that allow users to use the TinyMCE
  // plugin AND the Add Image link (visibility of this link is now a setting).
  // However, on my site I turned off the text link since I use TinyMCE. I think
  // it would confuse users to have an Add Images link AND a button on the
  // TinyMCE toolbar.
  //
  // Note that in both cases the img_assist.css file is loaded last. This
  // provides a way to make style changes to img_assist independently of how it
  // was loaded.
  $output .= drupal_get_html_head();
  $output .= drupal_get_js();
  $output .= "\n<script type=\"text/javascript\"><!-- \n";
  $output .= "  if (parent.tinyMCE && parent.tinyMCEPopup && parent.tinyMCEPopup.getParam('popups_css')) {\n";
  $output .= "    document.write('<link href=\"' + parent.tinyMCEPopup.getParam('popups_css') + '\" rel=\"stylesheet\" type=\"text/css\">');\n";
  $output .= "  } else {\n";
  foreach (drupal_add_css() as $media => $type) {
    $paths = array_merge($type['module'], $type['theme']);
    foreach (array_keys($paths) as $path) {
      // Don't import img_assist.css twice.
      if (!strstr($path, 'img_assist.css')) {
        $output .= "  document.write('<style type=\"text/css\" media=\"{$media}\">@import \"". base_path() . $path ."\";<\/style>');\n";
      }
    }
  }
  $output .= "  }\n";
  $output .= "--></script>\n";
  // Ensure that img_assist.js is imported last.
  $path = drupal_get_path('module', 'img_assist') .'/img_assist_popup.css';
  $output .= "<style type=\"text/css\" media=\"all\">@import \"". base_path() . $path ."\";</style>\n";

  $output .= '<!--[if IE 6]><link rel="stylesheet" href="'.get_full_path_to_theme().'/style.ie6.css" type="text/css" /><![endif]-->'."\n";
  $output .= '<!--[if IE 7]><link rel="stylesheet" href="'.get_full_path_to_theme().'/style.ie7.css" type="text/css" /><![endif]-->'."\n";

  $output .= "</head>\n";
  $output .= '<body'. drupal_attributes($attributes) .">\n";

  $output .= theme_status_messages();

  $output .= "\n";
  $output .= $content;
  $output .= "\n";
  $output .= '</body>';
  $output .= '</html>';
  return $output;
}

//* Funktion zur Darstellung des Namens statt des Login in Beiträgen *//

function phptemplate_username($object) {

  if ($object->uid && $object->name) {
    // Shorten the name when it is too long or it will break many tables.
    if (drupal_strlen($object->name) > 20) {
      $name = drupal_substr($object->name, 0, 15) .'...';
    }
    else {
      $name = $object->name;
    }
    $profile = user_load(array('uid' => $object->uid));
    if ($profile->profile_firstname." ".$profile->profile_name) {
      if (drupal_strlen($profile->profile_firstname." ".$profile->profile_name) > 20) {
        $name = drupal_substr($profile->profile_firstname." ".$profile->profile_name, 0, 15) .'...';
      }
      else {
        $name = $profile->profile_firstname." ".$profile->profile_name;
      }
    }

    if (user_access('access user profiles')) {
      $output = l($name, 'user/'. $object->uid, array('title' => t('View user profile.')));
    }
    else {
      $output = check_plain($name);
    }
  }
  else if ($object->name) {
    // Sometimes modules display content composed by people who are
    // not registered members of the site (e.g. mailing list or news
    // aggregator modules). This clause enables modules to display
    // the true author of the content.
    if ($object->homepage) {
      $output = l($object->name, $object->homepage);
    }
    else {
      $output = check_plain($object->name);
    }

    $output .= ' ('. t('not verified') .')';
  }
  else {
    $output = variable_get('anonymous', t('Anonymous'));
  }

  return $output;
}

/**
 * Format the "Submitted by username on date/time" for each node
 *
 * @ingroup themeable
 */
/* function ht16_sb2_node_submitted($node) {
  return t('!name (@datetime)',
    array(
      '!name' => theme('username', $node),
      '@datetime' => format_date($node->created, 'short'),
    ));
}
*/

// Return a file based on the URL alias, else return a default file

function unique_section_header() {
  $path = drupal_get_path_alias($_GET['q']);
  list($sections, ) = explode('/', $path, 2);
  $section = safe_string($sections);
  if (!($section == "sportzeiten")) {
    list($sections, ) = explode('/', $path, 3);
	$section2 = safe_string($sections);
	$filepath = path_to_theme() . '/images/sections/bildlauf_' . $section2 .'.png';
	}
  else {
  $filepath = path_to_theme() . '/images/sections/bildlauf_' . $section .'.png';
  }
  if (file_exists($filepath)) {
    $output = $filepath;
  }
  else {
    $output = path_to_theme() . '/images/sections/bildlauf_allgemein.png';
  }
  return $output;
}

//Make a string safe
function safe_string($string) {
  $string = strtolower(preg_replace('/[^a-zA-Z0-9_-]+/', '-', $string));
  return $string;
}

// Submitted by and changed by

function phptemplate_node_submitted($node) {

  $time_unit = 86400; // number of seconds in 1 day => 24 hours * 60 minutes * 60 seconds
  $threshold = 1;

  if ($node->changed && (round(($node->changed - $node->created) / $time_unit) > $threshold)){ // difference between created and changed times > than threshold

    return t('Von !username (@created, zuletzt modifiziert am @changed)', array(
      '@changed' => format_date($node->changed, 'short'),
      '!username' => theme('username', $node),
      '@created' => format_date($node->created, 'short'),
    ));
  }
  else{
    return t('Von !username (@datetime)',
      array(
        '!username' => theme('username', $node),
        '@datetime' => format_date($node->created, 'short'),
      ));
  }
}

function ht16_sb2_preprocess_node(&$variables) {
  $node = $variables['node'];

  if($node->type == 'ht16news2') {
    if($node->field_ht16_teaserauto[0]['value'] == 1){
    $variables['template_file'] = 'node-ht16news2a';
    }
  }
  if($node->type == 'news_abteilung') {
    if($node->field_other_template[0]['value'] == 1){
    $variables['template_file'] = 'node-abtnews1';
    }
  }
}
