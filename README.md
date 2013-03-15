# Deflector extension template

## Overview

Deflector extension template is the base plugin scheme for writing and organizing in the right way a WordPress plugin in the wpXtreme
environment.

## System Requirements

* WordPress Development Kit (WPDK) framework 1.0.0.b3 or higher (last version is suggested)
* Wordpress 3.5 or higher (last version is suggest)
* PHP version 5.2.4 or greater
* MySQL version 5.0 or greater

## Browser compatibility

* We suggest to update your browser always at its last version.

## Versioning

For transparency and insight into our release cycle, and for striving to maintain backward compatibility, this code will be maintained under the Semantic Versioning guidelines as much as possible.

Releases will be numbered with the following format:

`<major>.<minor>.<patch>`

And constructed with the following guidelines:

* Breaking backward compatibility bumps the major (and resets the minor and patch)
* New additions without breaking backward compatibility bumps the minor (and resets the patch)
* Bug fixes and misc changes bumps the patch

For more information on SemVer, please visit http://semver.org/.

## Getting started

To write a WordPress plugin in the wpXtreme environment, you should follow a few simple rules.

### Organization of the file system

The file system structure is not binding. However, you should follow this standard nomenclature and organization to make it
 readable and compliant with other plugins created. However, some files and some content,
 such as comments ( as happens now for any other plugin), are required to build in the right way the foundation of
 a wpXtreme plugin. Here it is:

* **assets/**
* **classes/**
* defcon.php
* defines.php
* index.php
* main.php
* *(plugin name)*.php
* readme.md
* readme.txt

For compatibility reasons and for avoiding case sensitive errors, all files and folders should be lowercase.

### Folders

#### assets

This folder contains two subfolders and/or any other files/folders needed to run the plugin:

* js/
* css/

In `css` folder, create an `images` folder and put your plugin logo, at the right dimension suggested by the name:

* css/
 * images/
  * logo-16x16.png
  * logo-64x64.png
  * logo-80x80.png
  * logo-160x160.png
  * logo-512x512.png

#### defcon.php

> Questo file è uno snippet che permette di controllare ed avvertire l'utente se per qualsiasi motivo il framework wpXtreme non è partito.
    
#### defines.php

This file contains commodity constants for an easier access to some properties of your main plugin class. But here you can add your own plugin useful constants. This file, unlike `config.php` is loaded when the instance of the main class of the plugin is generated, thus allowing access to the proper content of `$this` pointer.

#### index.php

_Silent is golden._

This file is here only for security reason.

#### main.php

> Da rivedere e completare

This is the main file of the plugin, the one that contains the comment header used by WordPress to recognize and extract information about the plugin. 

##### header
All WordPress plugins, by definition, must have a header - in the form of comments - which allow them to be recognized by WordPress core. In wpXtreme environment this header must be complete because some key information is retrieved from this series of comments.

A standard header detectable in an open plugin is so shaped:

````php
/**
* Plugin Name: CleanFix
* Plugin URI: https://wpxtre.me
* Description: Clean and fix tools
* Version: 1.0.0
* Author: wpXtreme
* Author URI: https://wpxtre.me
*/
````
     
If you get the file containing this main header through the wpXtreme Developer Center, you'll have all header fields correctly filled with informations you chose: plugin name, plugin description, plugin author, plugin author URI. All token starting with `__WPXGENESI` will be replaced in the right way for you from the wpXtreme Developer Center:

````php
/**
* Plugin Name: Deflector extension template
* Plugin URI: https://wpxtre.me
* Description: Base template for extending Deflector. 
* Version: 1.0.0
* Author: wpXtreme <info@wpxtre.me>
* Author URI: https://www.wpxtre.me
* Text Domain: wpx-deflector-extension-template
* Domain Path: localization
*/
````
    
Moreover, you will automatically find all details about this header in the properties of the main class that inherits the `WPDKWordPressPlugin` base class. In fact, you can define your own constant shorthands for access to the basic properties of the plugin, such as:

````php
// ---------------------------------------------------------------------------------------------------------------------
// Shorthand
// ---------------------------------------------------------------------------------------------------------------------

define( 'WPXDEFLECTOREXTENSIONTEMPLATE_VERSION', $this->version );
define( 'WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN', $this->textDomain );
define( 'WPXDEFLECTOREXTENSIONTEMPLATE_TEXTDOMAIN_PATH', $this->textDomainPath );
````

#### (plugin name).php

> Da rivedere e completare

This file could be named as you wish, and this is the reason why you see the parenthesis around its name. If you get this file through the wpXtreme Developer Center, you'll have this file automatically renamed with a part of the plugin name you chose, in capitalize mode.
