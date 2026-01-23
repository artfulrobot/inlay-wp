# Inlay integration for WordPress

## What is Inlay?

It’s a way to configure custom forms and data presentations from within
CiviCRM that can then be added to external websites by way of a simple
`<script>` tag.

See the [CiviCRM Inlay extension](https://lab.civicrm.org/extensions/inlay)


## What is this plugin?

Inlay generates `<script>` tags, but these might be hard to put in the
right place, so this provides a WordPress shortcode.

Inlay provides shortcodes like this: `[inlay id="abcdef012345"]` to place
the inlay on your page.

## How to set it up

1. Install this extension

2. Visit **Settings » Inlay** from the admin pages.

3. Paste in any of your CiviCRM site's inlays' script tags and hit Save.

4. Add Inlay shortcodes where you want them.

## Changelog

### Version 20260123

Inlay (some time ago!) began using `defer` with its `<script>` tags, so
that loading the inlay does not hold up page rendering. This extension
lagged that, which meant that (a) it did not apply the `defer` attribute
and (b) it was unable to parse a full `<script ...></script>` tag pasted
in as configuration any longer as
[reported](https://github.com/artfulrobot/inlay-wp/issues/2#issuecomment-3780701331)

This version updates the parser and adds the `defer` attribute. It is
strongly recommended that you update the plugin.
