=== PROPER Shortcodes ===
Contributors: properwp, Hason7, joshcanhelp
Tags: shortcodes
Requires at least: 3.0
Tested up to: 4.0
Stable tag: 0.3
License: GPLv2 or later

A collection of useful shortcodes that can be used with any theme. 

== Description ==

Shortcodes are very useful little snippets that output special content in specific places using your post editor. PROPER Shortcodes adds these blocks functionality to your WordPress install. This plugin gives you 8 useful shortcodes that can be used in your content editor and everywhere else that shortcodes are parsed. 

This group is just the beginning; we'll be adding new shortcodes and shortcode-related functionality over time. For now, there is no settings page, just the shortcodes below that become active when the plugin is installed. 

This plugin will add all of the following shortcodes:

**[p_site_url]** **[site_url]** **[p_home_url]** **[home_url]**

Displays the site URL or home URL. Useful for adding links to pages on the site without hard-coding in the domain.

**[p_tagline]**

Displays the tagline for the site, changed at Settings > General.

**[p_template_url]**

Displays the current URL to the theme directory. Useful for adding links to images used in the theme. 

**[p_list_documents]**

Lists all documents attached to the current page page. The attachment Title becomes the link text and the Description is added just below the link. Attributes:

- "id" set to a whole number to change the page ID to use (default = current page)

"Documents" are determined by their file MIME type. The following MIME types will be displayed:
 
- text/plain
- text/csv
- text/tab-separated-values
- text/richtext
- application/rtf
- application/pdf
- application/msword
- application/vnd.ms-powerpoint
- application/vnd.ms-excel
- application/vnd.openxmlformats-officedocument.presentationml
- application/vnd.openxmlformats-officedocument.spreadsheetml
- application/zip

**[p_field]**

Display the contents from a custom field. Attributes:

- "name" set to the name of a custom field

**[p_pullquote]**

Wrap content with a custom div to call out quoted text. Attributes:

- "direction" set to "left" or "right" will change the side of the page the pull quote sits on (default = right)
- "width" set to a whole number in pixels determines the width of the box (default = "300")
- "font_size" set to a valid CSS font-size value like "20px" or "1.5em" will change the size of the font (default = "1.2em")
- "line_height" set to a valid CSS line-height value will change the space between lines of text (default = "1.5em").

**[p_list_subpages]**

Lists all child pages of a specified page id, or current sub-pages. Attributes:

- "id" set to a whole number will set the page ID to use (default = current page)

**[p_post_list]**

Displays a list of links to blog posts, ordered from newest to oldest. Attributes:

- "posts_per_page" set to a whole number will change the number of posts displayed (defaults to the setting at Settings > Reading > Blog posts per page)
- "offset" set to a whole number will determine the number of posts to skip from the beginning (default = "0")
- "category" set to a post category ID number or a category slug (default = none)

**[p_post_archive]**

Displays all published posts in the system organized by the month they were published

**[p_sitemap]**

Outputs a human-readable sitemap with links. Attributes:

- Set a post type to "hide" (or anything) to not display that type. Core post types displayed are "post," "page,
" and "attachment"

**[hr]**

Outputs an <hr> tag with styles, if desired

- "style" is straight CSS that's added to an inline attribute

== Installation ==

Activating the Proper Contact Form plugin is just like any other plugin. If you've uploaded the plugin package to your server already, skip to step 3 below:

1. In your WordPress admin, go to **Plugins > Add New**
2. In the Search field type "proper shortcodes"
3. Under "PROPER Shortcodes," click the **Install Now** link
4. Once the process is complete, click the **Activate Plugin** link
5. The shortcodes have been added to WordPress.  Simply add them to the page content to begin using them.

== Changelog ==

= 0.3 =
* Added [home_url]
* Added [hr]

= 0.2 =
* Added [p_post_archive]
* Added [p_sitemap]

= 0.1 =
* First development