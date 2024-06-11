=== Enfold Fast ===
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

This plugin will make Enfold faster.

== Changelog ==

= 1.2.30 =
* Updated: version in plugin.php file.

= 1.2.29 =
* Added: added removal of chart, before/after and lottie elements from Enfold.

= 1.2.28 =
* Fixed: generic `load-jquery` to jQuery enabler for custom uses.

= 1.2.27 =
* Added: generic `load-jquery` to jQuery enabler for custom uses.

= 1.2.26 =
* Fixed: Support for multiple Styles

= 1.2.25 =
* Added: Support for multiple Styles
* Added: Added ep-disable-unused-heading theme support to kill special-heading-border in Enfold Plus
* Removed: waypoints script loading 

= 1.2.24 =
* Added: Icon Circles to disabled elements list.

= 1.2.23 =
* Updated: Wrapped posts grid native load more label with a span tag.
* Updated: numbers element to prevent error from showing.

= 1.2.22 =
* Tweak: moved footer body.css into script tag so wp rocket can lazy load it.
* Added: option to load avia-merge-styles CSS via script tag to use in conjunction with WP Rocket delay script execution setting.
* Added: added no-js css file, that would show animated elements and lazy loaded backgrounds when JavaScript is disabled.
* Tweak: removed lottie element dependencies from lazy-enabler.js as lottie slider/lottie data-lazy is added via wrapper hooks now (requires EP Lotties 1.2.8)
* Tweak: improved lottie interaction with WP Rocket rucss.
* Added: EP Style to EP Numbers element.

= 1.2.21 =
* Added: support for Item/Posts Grid pagination (load more)

= 1.2.20 =
* Tweak: Moved EP Style setup to Enfold Plus, keep wrapper_data hooks in Enfold Fast

= 1.2.19 =
* Added: provided support for EP Style additional classes
* Added: provided support for EP Style for rows
* Tweak: added source to flky lazy load selector, this leaves null as src, wait for 3.0 release
* Added: Lazy Loading for Background Images on Section and Section overlay
* Tweak: improved magnific popup lazy load script on links

= 1.2.18 =
* Tweak: Moved THEME_STYLES constant setup to plugin.

= 1.2.17 =
* Tweak: Provided lazy_load_js and lazy_load_css helper function an echo parameter.

= 1.2.16 =
* Fix: fixed conditional for lazy load triggering

= 1.2.15 =
* Tweak: added lazy css target when using only css lazyloading
* Added: Provided lazy_load_js and lazy_load_css helper function for easier implementation on custom elements.

= 1.2.14 =
* Reverted: reverted adding social_share to list of default disabled elements, needed for most single templates.

= 1.2.13 =
* Reverted: reverted adding social_share to list of default disabled elements, needed for most single templates.

= 1.2.12 =
* Updated: added social_share to list of default disabled elements.

= 1.2.11 =
* Updated: Added removal of slideshow.css since we need to not-disable it from child due to change in Enfold 4.8.9 related to video backgrounds.
* Added: Moved disablement of elements here, added `avf_epf_disabled_elements` filter to be able to programmatically disable elements.

= 1.2.10 =
* Tweak: Animated Numbers, defaulted US format for large numbers

= 1.2.9 =
* Added: Animated Numbers, added option to place icons outside heading wrapper
* Tweak: Added conditional to lazy-enabler JS, to not modify attributes if already set

= 1.2.8 =
* Icons, added missing icon css code
* Animated Numbers, added class adding to viewport js

= 1.2.7 =
* Removed FacetWP lazy loading, FacetWP no longer requires jQuery

= 1.2.6 =
* Added icons to fa-fontello

= 1.2.5 =
* Updated ver 

= 1.2.4.9 =
* Added flickity hash (EP 0.1.8.8)

= 1.2.4.8 =
* Added support for FacetWP 3.8+
* Added support for mobile lightbox links

= 1.2.4.7 =
* Added BG video support

= 1.2.4.6 =
* Added custom animated number using number rollup, removed Enfold animated number support.

= 1.2.4.5 =
* Added small delay to avia_start_animation Event dispatch (helps with animated numbers triggering)

= 1.2.4.4 =
* Added Avia Option for enabling jQuery and disabling FacetWP speed modifications
* Separated Lazy Loader and FacetWP to their own script (so it can be used by other EP plugins)

= 1.2.4.3 =
* Fixed text block having static line height, changed to inherit

= 1.2.4.2 =
* Removed Animations on mobile

= 1.2.4.1 =
* Removed non-critical CSS defer by https://web.dev/defer-non-critical-css/, doesn't work on FF/IE