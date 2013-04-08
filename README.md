Note that this project is completely not ready for prime time. :-)

If you have ideas, please file an issue. Thanks.

What is LSLON?
--------------

LSLON is similar in function to JSON, JavaScript Object Notation.

LSLON stands for Letting Second Life Open Northward. Or something. Clearly we're not notating objects, so 'object notation' is a bit of a stretch. But let's pretend, and just call it Linden Scripting Language Object Notation.

Linden Scripting Language (LSL) is the in-world scripting language for Second Life and other virtual worlds.

LSLON is designed to be easy to parse in LSL. LSL can easily split strings into lists on delimiters with `llParseString2List()`. We use LSL's limited capabilities as constraints on our design of a file format that is easy for LSL to generate and parse.

LSLON is also designed to be as compact as possible, in order to move more content data through the tiny 2k size limit imposed by Second Life http transfers.

What does the LSLON Library do?
-------------------------------

LSLON Library is a package which contains a canonical parser in LSL.

It also contains an LSLON parser in PHP.

The PHP code is useful, while the LSL code is meant to demonstrate how the format works, and should be re-implemented for use-cases.

