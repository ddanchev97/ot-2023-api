# A little application that using the Google Translate API.

To install the application, you have to install(links how to be installed will be provided):
* PHP 8.1: https://www.cloudbooklet.com/how-to-install-or-upgrade-php-8-1-on-ubuntu-20-04/
* sudo apt-get install php8.1-xml
* Composer: https://getcomposer.org/download/
* Symfony CLI: https://symfony.com/download
* Yarn: https://classic.yarnpkg.com/lang/en/docs/install/#debian-stable
* run command: ``composer install`` to install all packages that application requires to work normally.

## Add google translate key
* Paste your JSON key to google-translate-auth.json file in the root directory.

## Replace google cloud console project id
Replace ``GOOGLE_CLOUD_PROJECT=proj_id`` in .env.local in root directory with your project_id.
