[![Build Status](https://travis-ci.org/paul-m/lslon.png?branch=master)](https://travis-ci.org/paul-m/lslon)

What is LSLON?
--------------

LSLON is a data interchange format similar in function to JSON, JavaScript Object Notation.

Linden Scripting Language (LSL) is the in-world scripting language for Second Life and other virtual worlds.

LSLON stands for Letting Second Life Open Northward. Or something. Clearly we're not notating objects, so 'object notation' is a bit of a stretch. But let's pretend, and just call it Linden Scripting Language Object Notation.

LSLON is designed to be easy to parse in LSL. LSL can easily split strings into lists on delimiters with `llParseString2List()`. We use LSL's limited capabilities as constraints on our design of a file format that is easy for LSL to generate and parse.

LSLON is also designed to be as compact as possible, in order to move more content data through the tiny 2k size limit imposed by Second Life http transfers.

What does the LSLON Library do?
-------------------------------

LSLON Library is a package which contains a canonical parser in LSL.

It also contains an LSLON generator in PHP. More PHP code forthcoming.

The PHP code is useful, while the LSL code is meant to demonstrate how the format works, and should be re-implemented for use-cases.

How do I run the tests?
-----------------------

The tests are written in PHPUnit. If you want to run them, you have to satisfy the dependencies, using Composer. (You can see some of how this works in the `.travis.yml` file.)

From the command line, first installing composer and grabbing the dependencies:

	cd lslon 	# cd to the project root
	curl -s https://getcomposer.org/installer | php
	./composer.phar update

Then we run the test:

	./vendor/bin/phpunit

You can see the most recent test build on Travis-CI here: https://travis-ci.org/paul-m/lslon

Want to participate?
--------------------

Fork and send a pull request. :-)
