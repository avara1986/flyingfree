.. contents::

======
Flying Free
======

Information
===========

Flying Free is a Job Finder

::

    http://www.ymc.ch/en/webscraping-in-php-with-guzzle-http-and-symfony-domcrawler

::

    http://symfony.com/doc/current/components/dom_crawler.html

::

    https://github.com/FriendsOfPHP/Goutte

==========
Cheatsheet
==========

Install Composer
================

::

    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer

Init Project
============

Create project
--------------

::

    composer create-project symfony/framekwork-standard-edition [PROJECT-NAME]

Virtual Server
--------------

::

    app/console server:run

Create Bundle
-------------

::

    app/console generate:bundle --namespace=App/ClientBundle --format=yml

Init Doctrine
=============

Create Database
-----------

::

	app/console doctrine:database:create

Test schema
-----------

::

    app/console doctrine:schema:create --dump-sql

Create Schema
-------------

::

    app/console doctrine:schema:create

Update Project
==============

Or when clone a existing repo.

::

    composer composer create-project symfony/framework-standard-edition [PROJECT-NAME]


Create getters and setters
--------------------------

::

    app/console doctrine:generate:entities [MyBulde]/Entity/Object

Load Fixtures
-------------

::
    app/console doctrine:fixtures:load

Others
======


Clear Cache
-------------

::

    app/console cache:clear
