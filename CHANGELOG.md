# Changelog

_New / Improve / Bugfix_

<br>

### 3.1.0

Released: 09-10-2023

- New: Add theme.json
- New: Add true block editor styles support
- New: Add support of fourth footer section (backported from cm-iwc)
- Improve: Change clamping style
- Improve: Modernize control structure
- Improve: Remove normalize.scss
- Improve: Shorten the name of block related style files
- Improve: Replace respond-to() with breakpoint() to make code more interchangeable
- Improve: Remove obsolete SCSS variables
- Improve: Remove obsolete accordion code
- Improve: Better spacing in footer
- Improve: Better spacing in teaser list
- Improve: Remove .lowercase, .uppercase (obsolete)
- Improve: Remove text alignment style settings (is set by Gutenberg)
- Improve: Add round corners, shadows and hover action to speaker-grid-elements
- Improve: Add better hover action to even-table speaker-images
- Improve: Add better hover action to teaser-list


### 3.0.0

Released: 21-07-2023

- New: Use namespace based theme vars (backport from [theme template](https://github.com/mdibella-dev/theme-template))
- New: Add namespace **cm_theme**
- Improve: Extract changelog from README.md.
- Improve: Outsource FAQ code into plugin [CM Theme — FAQ](https://github.com/mdibella-dev/cm-theme-addon-faq)
- Improve: Outsource CM core functions, taxonomies, post-types etc. into plugin [CM Theme — Core](https://github.com/mdibella-dev/cm-theme-core)
- Improve: Change array notation
- Improve: Update changelog notation
- Improve: Change package designation from **cm*- to **cm-theme**
- Improve: Remove FontAwesome CDN support (use plugin instead)
- Improve: Remove obsolete ACF file
- Improve: Rename assets/dev to assets/src and assets/src/scss to assets/src/css
- Bugfix: Fix undefined array key "forename" in core-speakers.php
- Bugfix: Fix language path


### 2.6.0

Released: 03-02-2023

- New: Separator lines in admin menu
- New: Support of Roboto Flex
- New: Support of plugin cmkk (backport from cm-iwc)
- New: Default header template file for live page
- Improve: Split core.php in separate files
- Improve: Directory structure
- Improve: Include strategy
- Improve: Changelog style and laguage
- Improve: Documentation style and language
- Improve: Remove cm_remove_thumbnail_width_height()
- Improve: Remove ICBM meta tag
- Bugfix: Exhibitor (backend): Empty exhibition areas are no longer displayed


### 2.5.0

Released: 07-04-2022

- New: Situation specific titling
- New: Localities shows the number of program items or exhibition areas
- New: Turning off the slugs and description columns by default
- New: Displaying an image for locations
- New: More detailed overview of taxonomies and post types
- New: Inactive/Active display for events (issue #9)
- New: Backend CSS
- Improve: Code style
- Improve: Text domain
- Improve: Package info
- Improve: Menu order
- Improve: Menu name and icon
- Improve: SCSS and CSS separated from each other
- Improve: Speaker: Set from 4 to 1 for program items
- Improve: Remove Unnecessary image sizes
- Bugfix: Number links in the overviews now work correctly
- Bugfix: Correction of the standard sorting for the exhibition areas
- Bugfix: Speaker: If there are no program items, nothing is displayed
- Bugfix: Exhibitors: Empty exhibition spaces are no longer displayed


### 2.4.0
Released: 06-11-2020

- Improve: Code style


### 2.3.0
Released: 06-08-2020

- New: Style sheet versioning
- New: Detail page for cooperation partners
- New: Posttype for exhibition space
- New: Taxonomy for exhibitor packages
- New: Common admin menu for all CM components (except FAQ)
- New: Mixin for figcaption (affects embeds, images)
- New: Button style Gray-Shaded
- New: Shortcode [icon-wall]
- New: Shortcode [exhibition-list]
- New: Display of blocks in the block editor
- Improve: Spacing for embeds, images
- Improve: speaker grid
- Improve: single-speaker.php + classes
- Improve: Button styles
- Improve: Remove .is-style-with-caption
- Improve: Remove Shortcode [partner-list]
- Bugfix: Color palette
- Bugfix: rendering of .wp-block-cover in block editor
- Bugfix: Width of blocks by root element in block editor
- Bugfix: Line height on wp-block-image


### 2.2.0
Released: 14-05-2020

- New: .post-title, .page-title
- New: Spacer Block
- Improve: Directory structure
- Improve: Teaser without 'More' button
- Improve: Presenters page (Backport from 'Winterakademie')
- Bugfix: Extra space on .teaser-image
- Bugfix: Width of block editor (codeview)


### 2.1.0
- New: Support for multiple program item assignments
- New: Description for program items
- New: .accordion
- Improve: Commenting and code refactoring
- Improve: Templates for Download Monitor
- Improve: Shortcode event table
- Improve: FontAwesome5 integration
- Improve: Main Navigation (QuadMenu integration)
- Improve: Remove cm_excerpt_more()
- Improve: Remove cm_remove_script_version()
- Improve: Remove cm_special_replacements()


### 2.0.0
- Improve: Directory structure of the theme
- Improve: Merged changelog and readme
- Improve: Backend menus
- Improve: Registration of widget areas
- Bugfix: Input dialog for a program point
- Bugfix: Display of all sessions of a speaker


### 1.0.0
Released: 01-01-2019

- Initial commit
