# Inlay integration for WordPress

## What is Inlay?

It’s a way to configure custom forms and data presentations from within
CiviCRM that can then be added to external websites by way of a simple
`<script>` tag.

See the [CiviCRM Inlay extension](https://lab.civicrm.org/extensions/inlay)


## What is this plugin?

Inlay generates `<script>` tags, but these might be hard to put in the
right place, so this provides a WordPress shortcode.

e.g. if Inlay gives you code like this:

```
<script src="https://example.org/sites/default/files/civicrm/inlay-abcdef012345.js" data-inlay-id="abcdef012345" ></script>
```

Then you can use a shortcode like this: `[inlay id="abcdef012345"]` to place
the inlay on your page.

## How to set it up

1. Install this extension

2. Visit **Settings » Inlay** from the admin pages.

3. Paste in any of your CiviCRM site's inlays' script tags and hit Save.

4. Add Inlay shortcodes where you want them.
