_2016.11.22 13:30_

# Schmolck Web Framework

Web framework based on PHP, HTML, JS and LESS. 

## Structure

**Application**

The framework may contain several **applications** for various servers or domains. Within the applications you find **modules** for further separation of functionality.

**Apps**

Within each subfolder you can build small tools for several functions, e.g.:
- image - image resizer tool
- script - JavaScript minification tool
- style - CSS minification tool

**Host**

Each file within the host folder represents a **server** or domain. Therefore you can have different configurations per server depending on the url; e.g. http://localhost/framework/ will load the file host/development/localhost.php 

**Library**

Every library regardless whether JavaScript, CSS or PHP is stored here. The whole framework is stored within 

> library/schmolck/framework

PHP classes will automatically be resolved to the corresponding library folder structure; e.g. the declaration for _Schmolck_Framework_Core_ class will be searched within 

> library/schmolck/framework/core/core.php


## Processing

Within the file _index.php_ GET **parameters** get parsed from the URL structure and the **framework** gets initialised and run. The framework is built up within the **core** class _Schmolck_Framework_Core_. There you find several **helper** classes which add further functionality like session handling, database connection, message handling, redirecion, caching, ... The **URL** on the development machine could look like this: 

> http://localhost/framework/application/module/controller/action/parameter1/parameter2/… 