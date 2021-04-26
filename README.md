# WordPress Slideshow Plugin - rtCamp Assignment 

A WordPress plugin for rtCamp rtCamp assignment. 😎 <br />
[![Build Status](https://scrutinizer-ci.com/g/mahbubme/WP-Slideshow/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mahbubme/WP-Slideshow/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/mahbubme/WP-Slideshow/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mahbubme/WP-Slideshow/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mahbubme/WP-Slideshow/?branch=master)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg?style=flat-square)](https://php.net/)
[![License](https://img.shields.io/badge/license-GPL--3.0%2B-red.svg)](https://github.com/mahbubme/WP-Slideshow/blob/master/license.txt)

## 🚚 Installation

1. Download the zip file of this repository
2. Login to your site admin, go to Plugins -> Add New
2. On top of the page, click “Upload Plugin” button
3. Click on “Choose File” button
4. Select the ZIP file of this plugin from your computer.
5. Click “Install Now” button
6. Wait for a few seconds for WordPress to complete the installation
7. Activate the plugin

## Usage

Navigate to the plugin settings page: `wp-admin -> Settings -> WP Slideshow`. Now upload images for the slider using WP Media Uploader and save the changes.

Now add shortcode `[wp_slideshow]` to any page and save. Check the page on the frontend, it will be replaced by a slideshow of images uploaded from admin-side.

Or, you can watch the video guidelines [here](https://youtu.be/e0RNuAXKV5o) 

Please feel free to check the demo slider of this plugin [here](https://mahbub.me/wp-slideshow-demo/slider/)


## 💻 Development Procedure

Please follow the development guidelines to extend the plugin functionalities or to fix any bug/issue of this plugin.

- Add the following line in your wp-config.php file. `SCRIPT_DEBUG` is a related constant that will force WordPress to use the `dev` versions of core CSS and JavaScript files. This is useful when you are testing modifications to any built-in .js or .css files.

`define( 'SCRIPT_DEBUG', true );`

- Use command line to change your working directory to plugin's directory: 

`cd /path-to-plugins-directory/wp-slideshow`

- You must initialize the development environment using composer and npm:

`npm install` 

`composer install`

- You need to check the JavaScript codes to detect errors and potential problems. After making any changes to plugin's JavaScript files run the following command.   

`npm run lint:js`

- To fix the JavaScript fixable errors automatically:

`npm run lint-fix:js` 

- To detect violations of pre-defined PHP & WordPress coding standards(WPCS):

`composer run:cs`

- To resolve the fixable PHP & WPCS errors:

`composer fix:cbf`

- Initialize the testing environment

Please make sure that you have [mysql](https://dev.mysql.com/downloads/mysql/) running in your computer. Replace `<username>` `<password>` with your mysql username and password. If you don't have password setup then leave the `<password>` with `''` syntax. 

`bash bin/install-wp-tests.sh tests-wp-slideshow <username> <password> localhost latest`

- Start Testing

Run PHPUnit. You can add more tests to the `tests` directory as well. 

`composer run:phpunit`

- Plugin build process

Run the following command, commmit the changes and push to [Github](https://github.com/mahbubme/WP-Slideshow/). Replace `<version>` with any of the value(e.g: `v2.4.0`)

`./vendor/bin/robo release <version>`

Note: when you make a code change and push to GitHub, a build will be triggered on Travis CI.

## 🐞 Bugs
If you find an issue, let me know [here](https://github.com/mahbubme/WP-Slideshow/issues?state=open)!


