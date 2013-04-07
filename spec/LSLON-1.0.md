
Paul Mitchum, Feb. 10, 2011

I propose LSLON.

What is LSLON?
--------------

LSLON is similar in function to JSON, JavaScript Object Notation.

LSLON stands for Letting Second Life Open Northward. Or something. Clearly we're not notating objects, but oh well.

LSLON exists to provide a structured way for LSL to talk to web servers and vice-versa. LSL is the Linden Scripting Language, which is the in-world scripting language for virtual worlds like Second Life and the OpenSimulator diaspora. LSL has systems in place to make http requests, and also to serve as a low-performance http server.

Eventually we'll come up with a `Content-Type`, but for now it's just `text/plain`, since that's what LSL's http system forces us to use.

Note also that the same parser could be used in-world, on linked messages and inter-object chat and email, so this format can serve many purposes.

LSLON is designed to be easy to parse in LSL. LSL can easily split strings into lists on delimiters with `llParseString2List()`. We use LSL's limited capabilities as constraints on our design of a file format that is easy for LSL to generate and parse.

LSLON is also designed to be as compact as possible, in order to move more content data through the tiny 2k size limit imposed by Second Life http transfers.

How does it work?
-----------------

LSLON is composed of lines separated by newlines. Empty lines are ignored. The first line will be a version line, something like this: `LSLON 1.0`. This lets any parser know that it is, in fact, dealing with LSLON, and also gives an avenue for backward compatibility in the future.

Subsequent lines are name/value list pairs. LSLON encodes a one-dimensional array ('list' in LSL) and gives it a name. We call the names 'names' because 'key' is a variable type in LSL. (In LSL, a key is a UUID value.)

Both string values and names must be URL encoded. This is to make sure they don't contain delimiters. This means that an untyped string value could have an ambiguous encoding. In this case, sender and receiver have to agree on the type.

Numeric types and keys must NOT be encoded. Integers won't need encoding. Keys, floats, vectors, and rotations will never generate the pipe delimiter. We avoid this encoding in order to avoid its attendant performance overhead.

Numeric values with many trailing zeros (such as a float like 1.0000) can of course truncate them to use fewer characters, but float values must always have at least a trailing .0. This means a vector would be truncated as such: <0.0,0.0,0.0>.

So what does it look like?
--------------------------

There are two types of variable declarations in LSLON: Arrays and typed arrays. Both take the basic form of:

	name=value|value|value
	name=TYPED|type|value|type|value

If you need only one value rather than an array, you should create an array with only one element. (`name=value` or `name=TYPED|type|value`)


ARRAYS look like this:

	name=value|value|value

Since this kind of array has no type markers, both sender and recipient have to know which type belongs where. For instance, an untyped string will end up as a URL-encoded string. That is, the parser will have no way of knowing whether the string should be decoded, so it shouldn't. The obvious solution here is to use a typed array, or have a data structure where the type is known by both sender and receiver.


TYPED ARRAYS look like this:

	name=TYPED|type_constant|value|type_constant|value|type_constant|value

`TYPED` is a string that tells the parser this array is typed. (We should come up with some better marker.) The type constants are those returned by the LSL function `llGetListEntryType()`. The value following the type constant should be coerced to that type.

`llGetListEntryType()` is documented here: http://wiki.secondlife.com/wiki/LlGetListEntryType

And these are the values it returns:

	LSL Constant	Value		Type   
	TYPE_INTEGER	1			integer
	TYPE_FLOAT		2			float
	TYPE_STRING		3			string
	TYPE_KEY		4			key
	TYPE_VECTOR		5			vector
	TYPE_ROTATION	6			rotation
	TYPE_INVALID	0			none


What do I do with this in LSL?
------------------------------

Processing LSLON in LSL:

1) Parse the data string to list delimited on line breaks with `llParseStringToList()`.

2) For each line, parse string to list with = as delimiter. This gives you a strided list: `["name", "value|value|value"]`

3) combine all name/value pairs into one strided list: `["name1", "value|value", "name2", "value|value|value"]`

4) To look up a named value, find the name in the list, add one to the index, and retrieve the value string.

5) To process the value string: Parse the value string to a list, on the | delimiter with `llParseString2List()`.

6) If element 0 is `TYPED` then loop through the items and cast accordingly

7) If element 0 is not `TYPED` then you have your list.

8) If LSL had multidimensional arrays, or arrays containing arrays, this would be much easier.


What do I do with this in PHP?
------------------------------

..or whatever other language you'll be using...

Obviously this can be useful in any number of ways. You can parse this format into key->array(values...) type array structures, or elements could be parsed as needed.

PHP sample code forthcoming.
