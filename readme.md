# Download List with Icons Preview

This plugin adds the possibility to show generated preview-images on each entry of a "Download List Block with Icons"-block. The plugin "Download List Block with Icons" is necessary to use this plugin.

## Hints

The preview images are generated through WordPress. Whether and how they are created depends on whether WordPress and the hosting support the respective data format. For example, ghostscript is required in the hosting to generate preview images of PDF files.

The preview images are integrated using a style. If you want to display them larger, an individual style adjustment is necessary.

## Usage

### For user

1. Download the release ZIP (not the source ZIP).
2. Install this plugin ZIP in your backend.
3. Activate the plugin.

### For developer

1. Checkout the repository in your plugin folder of your development environment.
2. Activate the plugin in WordPress backend.

## Translations

I recommend to use [PoEdit](https://poedit.net/) to translate texts for this plugin.

### generate pot-file

Run in main directory:

`wp i18n make-pot . languages/download-list-preview.pot`

### update translation-file

1. Open .po-file of the language in PoEdit.
2. Go to "Translate" > "Update from POT-file".
3. After this the new entries are added to the language-file.

### export translation-file

1. Open .po-file of the language in PoEdit.
2. Go to File > Save.
3. Upload the generated .mo-file and the .po-file to the plugin-folder languages/

## Check for WordPress Coding Standards

### Initialize

`composer install`

### Run

`vendor/bin/phpcs --extensions=php --ignore=*/vendor/* --standard=ruleset.xml .`

### Repair

`vendor/bin/phpcbf --extensions=php --ignore=*/vendor/* --standard=ruleset.xml .`

## Check for WordPress VIP Coding Standards

Hint: this check runs against the VIP-GO-platform which is not our target for this plugin. Many warnings can be ignored.

### Run

`vendor/bin/phpcs --extensions=php --ignore=*/vendor/* --standard=WordPress-VIP-Go .`