<?php
// $Id: colorbox-insert-image.tpl.php,v 1.1.2.1 2010/11/10 06:51:37 frjo Exp $

/**
 * @file
 * Template file for Colorbox content inserted via the Insert module.
 *
 * Available variables:
 * - $item: The complete item being inserted.
 * - $image_path: The URL to the image.
 * - $link_path: The URL to the image that Colorbox should open.
 * - $presetname: The ImageCache preset being used.
 * - $gallery_id: The ID of the Colorbox gallery.
 *
 * Note that ALT and Title fields should not be filled in here, instead they
 * should use placeholders that will be updated through JavaScript when the
 * image is inserted.
 *
 * Available placeholders:
 * - __alt__: The ALT text, intended for use in the <img> tag.
 * - __title__: The Title text, intended for use in the <img> tag.
 * - __description__: A description of the image, sometimes used as a caption.
 */
?>
<a href="<?php print $link_path; ?>" title="__title__" class="cbox2 colorbox colorbox-insert-image" rel="gallery-<?php print $gallery_id; ?>"><img src="<?php print $image_path; ?>" alt="__alt__" title="__title__" class="cbox2 imagecache imagecache-<?php print $presetname; ?>" /></a>