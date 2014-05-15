<?php
/**
 * Implements hook_html_head_alter().
 * This will overwrite the default meta character type tag with HTML5 version.
 */
function incar_html_head_alter(&$head_elements) {
  $head_elements['system_meta_content_type']['#attributes'] = array(
    'charset' => 'utf-8'
  );
}

/**
 * Insert themed breadcrumb page navigation at top of the node content.
 */
function incar_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  if (!empty($breadcrumb)) {
    // Use CSS to hide titile .element-invisible.
    $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';
    // comment below line to hide current page to breadcrumb
  $breadcrumb[] = drupal_get_title();
    $output .= '<nav class="breadcrumb">' . implode(' » ', $breadcrumb) . '</nav>';
    return $output;
  }
}

/**
 * Override or insert variables into the page template.
 */
function incar_preprocess_page(&$vars) {
  if (isset($vars['main_menu'])) {
    $vars['main_menu'] = theme('links__system_main_menu', array(
      'links' => $vars['main_menu'],
      'attributes' => array(
        'class' => array('links', 'main-menu', 'clearfix'),
      ),
      'heading' => array(
        'text' => t('Main menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      )
    ));
  }
  else {
    $vars['main_menu'] = FALSE;
  }
  if (isset($vars['secondary_menu'])) {
    $vars['secondary_menu'] = theme('links__system_secondary_menu', array(
      'links' => $vars['secondary_menu'],
      'attributes' => array(
        'class' => array('links', 'secondary-menu', 'clearfix'),
      ),
      'heading' => array(
        'text' => t('Secondary menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      )
    ));
  }
  else {
    $vars['secondary_menu'] = FALSE;
  }
}

/**
 * Duplicate of theme_menu_local_tasks() but adds clearfix to tabs.
 */
function incar_menu_local_tasks(&$variables) {
  $output = '';

  if (!empty($variables['primary'])) {
    $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
    $variables['primary']['#prefix'] .= '<ul class="tabs primary clearfix">';
    $variables['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['primary']);
  }
  if (!empty($variables['secondary'])) {
    $variables['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
    $variables['secondary']['#prefix'] .= '<ul class="tabs secondary clearfix">';
    $variables['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['secondary']);
  }
  return $output;
}

/**
 * Override or insert variables into the node template.
 */
function incar_preprocess_node(&$variables) {
  $node = $variables['node'];
  if ($variables['view_mode'] == 'full' && node_is_page($variables['node'])) {
    $variables['classes_array'][] = 'node-full';
  }
}

function incar_page_alter($page) {
  // <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
  $viewport = array(
    '#type' => 'html_tag',
    '#tag' => 'meta',
    '#attributes' => array(
    'name' =>  'viewport',
    'content' =>  'width=device-width'
    )
  );
  drupal_add_html_head($viewport, 'viewport');
}

/* Custom */
/**
 * Implements THEMENAME_admin_menu_icon() for administration menu.
 */
function disable_incar_admin_menu_icon() {
  // Image source might have been passed in as theme variable.
  if (!isset($variables['src'])) {
    if (theme_get_setting('toggle_favicon')) {
      drupal_set_message("Set icon to toggle_favicon");
      $variables['src'] = theme_get_setting('favicon');
    }
    else {
      drupal_set_message('default misc favicon.');
      $variables['src'] = base_path() . 'misc/favicon.ico';
    }
  }
  
  drupal_set_message('Admin menu icon is: ' . $variables['src']);
  // Strip the protocol without delimiters for transient HTTP/HTTPS support.
  // Since the menu is cached on the server-side and client-side, the cached
  // version might contain a HTTP link, whereas the actual page is on HTTPS.
  // Relative paths will work fine, but theme_get_setting() returns an
  // absolute URI.
  $variables['src'] = preg_replace('@^https?:@', '', $variables['src']);
  $variables['src'] = check_plain($variables['src']);
  $variables['alt'] = t('Home');
}

/**
 * Implements template_preprocess_hook() to overload nivo slider module hook.
 */
function disable_incar_preprocess_nivo_slider_wrapper(&$variables) {
  //print('now i\'m hook nivo slider wrapper now.');
  $variables['theme'] = variable_get('nivo_slider_theme', 'default');
  $variables['banners'] = nivo_slider_slider();
  $variables['html_captions'] = variable_get('nivo_slider_banner_html_captions', '');
}