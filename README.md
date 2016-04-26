# DengruDiscuss
DengruDiscuss is a PHP-powered discussion board software created for the sole purpose of simplicity.

Features:
* Forum Management - this feature allows a forum administrator to lock threads, delete threads/posts and edit users

* Dynamic Address Routing - a feature that implements dynamic url addressing, which allows for better robot-crawling and better flexibility for the frontend. It simply routes an address action like "index.php?q=thread&id=31" to the thread's title name that is set when creating a new thread. For example, the alias could be something like "my-new-thread" or "introduce-yourself-to-others". This feature works with a webserver like Apache and Nginx or any other that supports dynamic url-rewriting.

* TinyMCE WYSIWYG - an user-friendly what-you-see-is-what-you-get text-editor that is implemented every time a new thread or post is to be made. It lets you customize your content with an stylish text colour, a row background or a smiley for example.

* Dynamic Templating - the backend-content is handled by rending html/php-templates instead of loading the page header and footer more than just a single time. A template might have a name like "index.tpl" or "thread.tpl", and each one of these handles their own content and purpose. For instance, the "thread.tpl" template is rendered when a user enters a thread in the forum board. This is a very neat feature that allows for pure creativity.

* PDO - the software is writed using the PDO-extention within the MySQL-package, with the purpose of allowing any type of database that supports the PDO-driver to be used, in other words, this system doesn't constrain you to use the regular MySQL database. Instead you can use the one you prefer the best. It could be MySQLi, MSSQL or postgresql. Pick and go!
* ... and many other features!


This software is copyrighted and prohibited for any unauthorized usage.

DengruDiscuss - All rights reserved (c) 2016. Written by Dennis Grundelius
