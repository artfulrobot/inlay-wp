# Inlay integration for WordPress

## What is Inlay?

It’s a way to configure custom forms and data presentations from within
CiviCRM that can then be added to external websites by way of a simple
`<script>` tag.

## What is this plugin?

Inlay generates `<script>` tags, but these might be hard to put in the
right place, so this provides a WordPress shortcode.

e.g. if your Inlay code looks like this:

```
<script src="https://example.org/sites/default/files/civicrm/inlay-abcdef012345.js" data-inlay-id="abcdef012345" ></script>
```

Then you can use a shortcode like this: `[inlay id="abcdef012345"]` to place
the inlay on your page.
