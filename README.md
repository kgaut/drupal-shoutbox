# Shoutbox for drupal 8
## Disclaimer
This is a work in progress module for drupal 8.

It allows to create multiple shoutboxes, and provide a block to see it.

## Installation and configuration

### Downloading
Via composer 
```
composer require kgaut/shoutbox
```

### Enable the module
Through the UI : /admin/module

or via drush : `drush en shoutbox`

### Configure the permissions
Through the UI : `/admin/people/permissions`

### Create your first shoutbox
Through the UI : `/admin/content/shoutbox`

You can access it via `/shoutbox/ID` eg : `/shoutbox/1`.

You can also place a block and select the shoutbox you want to display
