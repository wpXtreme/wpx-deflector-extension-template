# Deflector extension template

## Overview

__Deflector Extension Template__ is a plugin that extends with some sample security rules the __Deflector__ plugin. It has to be considered as a simple template for how to extend __Deflector__ with specific behaviours in form of external plugins.

## Basic behaviour

__Deflector Extension Template__ internally creates some simple security rules that does nothing but set a generic string param. Then, it extends __Deflector Kernel__ in its three possible ways:

* it adds a security rule to an already existent Deflector rules collection ( i.e., the collection in Basic Shields tab )
* it adds a brand new rules collection containing a new rule to an already existent Deflector tab ( i.e. the Basic Shields tab )
* it adds to Deflector a brand new tab with a brand new rules collection containing a new rule ( this new tab is called _A Brand New Tab_ )

Security rules into these extensions does nothing but set an internal param. However, their status is set through the Ajax channel making available by __Deflector__; they make use of a simple Twitter Bootstrap Modal window to set their own param.

These security rules are then attached to `init` WordPress action, and executed when WordPress fires this action. A message into `admin_notices` WordPress area informs user that these sample rules are running.

## System Requirements

* WordPress Development Kit (WPDK) framework 1.0.0.b4 or higher (last version is suggested)
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
