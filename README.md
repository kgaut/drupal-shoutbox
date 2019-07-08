# Shoutbox for drupal 8
## Disclaimer
This is a work in progress module for drupal 8.

## Installation and configuration

### Repository configuration
Add the following lines to the `repositories` section of your composer.json file : 
```
"drupal-shoutbox": {
    "type": "vcs",
    "url": "https://github.com/kgaut/drupal-shoutbox"
}
```

### Downloading
Via composer 
```
composer require kgaut/shoutbox
```

### Enable the module
Through the UI : /admin/module

or via drush : `drush en shoutbox`

### Configure the permissions
