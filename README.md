# WPLib Juicer Module
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/clubdeuce/wplib-olm-juicer/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/clubdeuce/wplib-olm-juicer/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/clubdeuce/wplib-olm-juicer/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/clubdeuce/wplib-olm-juicer/?branch=develop)

[![Waffle.io - Columns and their card count](https://badge.waffle.io/clubdeuce/wplib-olm-juicer.svg?columns=all)](https://waffle.io/clubdeuce/wplib-olm-juicer)

This is a [WPLib](https://github.com/wplib/wplib) module for [Juicer](https://juicer.io), a social media aggregation service.

## Including in your project

## Usage
The simplest way to use this module is to simply use the `Juicer::get_feed( $args )` method. The parameter for this method should always include the feed name. All other parameters are optional:
 
 ```
 $feed = Juicer::get_feed( array(
    'feed'        => 'myFeedName',
    'per'         => 10,
    'page'        => 1,
    'filter'      => 'Facebook',
    'starting_at' => '2017-01-01',
    'ending_at'   => '2017-01-07',
 ) );
 ```
 
 The above method will return a [Feed](#feed) object.


## Objects
The following objects are exposed by this module:

<a name="feed"></a>
### Feed

The feed object contains all information available about the feed.

#### Properties
There are no publicly accessible properties.

#### Methods
All of the properties exposed by the [Juicer API](https://juicer.io/api#feed) can be accessed using the corresponding method. For example, to get the `last_synced` value you may simply call `$feed->last_synced();`. 