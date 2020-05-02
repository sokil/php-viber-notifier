# PHP Viber notifier

Allows to implement subscription on Viber's account and broadcast notifications to different groups (roles) of subscribed users. 

[![Total Downloads](http://img.shields.io/packagist/dt/sokil/php-viber-notifier.svg)](https://packagist.org/packages/sokil/php-viber-notifier)
[![Build Status](https://travis-ci.org/sokil/php-viber-notifier.png?branch=master&2)](https://travis-ci.org/sokil/php-viber-notifier)
[![Coverage Status](https://coveralls.io/repos/sokil/php-viber-notifier/badge.png)](https://coveralls.io/r/sokil/php-viber-notifier)

## Installation

```
composer require sokil/php-viber-notifier
```

## Usage

To start sending notifications via Viber we need to [create bot](https://developers.viber.com/docs/api/rest-bot-api/#get-started) first.

When user joins Viber's chatbot, Viber sends postback request to our site with subscribed user details. 
Then we may send notifications to all subscribed users.

Users may have different roles, so we may broadcast different messages to different roles of users.

### Subscribers repository

First we need to implement storage where subscribed Viber users and their roles will be stored.

Storage must implement `SubscribersRepositoryInterface`. 

### Viber chat bot client

If you already have convigured Viber bot in your project, just create adapter by implementing interface `ViberClientInterface`.
If you have no chatbot in you project, use basic implementation `ViberClient`.



