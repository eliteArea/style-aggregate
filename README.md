# Style aggregate

## Requirements

* CodeIgniter 2
* [CodeIgniter Sparks](http://getsparks.org/)

## Setup

1. [Install Sparks](http://getsparks.org/install) if you haven't done so already.
2. Install the google-analytics-lib spark (see [here](http://getsparks.org/get-sparks) if you don't know how).

## Info

Style aggregate is a spark that allows to include style to your web page via config file. You can
 also turn on aggregation.

Aggregation use for group , compress and clean your css file from comment and empty space. Reduce
size of file and improve load performance.

## Usage

controler call

## $this->load->spark('style-aggregate/x.x.x');

To load the aggregate spark..


## style-aggregate

#### incluede:

	config-> autoload.php
	config-> config.php
	libraries->aggregate.php

#### Setup:

in config file you need to set
 - style_destionation - where to save compressed file.
 - public_html - folder to public web directory only if you move your root code igniter under
 separate directory.
 - aggregate - set if aggregator off or on

 - stylepath = array call all your style which want to compress or load.


Into your views file in header you need to seample call global variable STYLE.

if( defined('STYLE') ) {
  print( STYLE );
}

When ENVIRONMENT setup to production your google analytics will be include into the page.
