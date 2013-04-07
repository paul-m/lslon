// LSLON Example Code
// by Paul Mitchum

// NOTE: This document is designed to illustrate how to accomplish
// parsing LSLON. It favors readability over efficiency and memory
// limitations. Use these concepts to create your own parser
// and if you feel so moved, give it to the community.

// I'm using a lslon_ prefix for the function names, to get the
// namespace-collision-prevention ball rolling.

// -- Paul Mitchum


// PARSE........

list lslon_parseString2LSLON(string input)
{
    // input is raw LSLON.
    // return a list containing the key/value strided list
    list parsed = llParseString2List(input, ["\n","="], [""]);
    // check for version line
    if (llList2String(parsed, 0) != "LSLON 1.0") return [];
    // we have a version line so trim it off and return
    // the remainder.
    return llDeleteSubList(parsed, 0,0);
}

list lslon_valueForKey(list lson, string nameKey)
{
    // return the value for the key, as a list
    list result;
    integer index = llListFindList(lson, [nameKey]);
    if (index >= 0)
    {
        result = lslon_parseValue(llList2String(lson, ++index));
    }
    return result;
}

list lslon_parseValue(string value)
{
    // parse out the list, coercing type if required
    // tested with well-formed data
    list items = llParseString2List(value, ["|"], [""]);
    if (llList2String(items, 0) == "TYPED")
    {
        list cast;
        integer i;
        integer count = llGetListLength(items);
        integer type;
        for (i=1; i<count; i = i+2)
        {
            type = llList2Integer(items, i);
            if (type == TYPE_INTEGER) cast += [llList2Integer(items, i+1)];
            if (type == TYPE_FLOAT) cast += [llList2Float(items, i+1)];
            if (type == TYPE_STRING) cast += [llUnescapeURL(llList2String(items, i+1))];
            if (type == TYPE_KEY) cast += [llList2Key(items, i+1)];
            if (type == TYPE_VECTOR) cast += [(vector)llList2String(items, i+1)];
            if (type == TYPE_ROTATION) cast += [(rotation)llList2String(items, i+1)];
        }
        return cast;
    }
    return items;
}


// ENCODE............

string lslon_encodeListForKey(list items, string keyname, integer typed)
{
    // variables:
    //  items is the list of values for the key
    //  keyname is the name of the key for the values
    //  typed is a boolean, indicating whether the list should be
    //    encoded as typed or not.
    list values;
    if (typed) values += ["TYPED"];
    integer count;
    integer i;
    count = llGetListLength(items);
    for (i=0; i<count; ++i)
    {
        // get the type so we can know whether to url-escape a string
        integer type = llGetListEntryType(items, i);
        // add the type marker if it's desired
        if (typed)
        {
            values += [type];
        }
        // url-escape strings, but not anything else.
        if (type == TYPE_STRING) values += llEscapeURL(llList2String(items, i));
        else values += [llList2String(items, i)];
    }
    // now we assemble the whole thing.
    return llEscapeURL(keyname) + "=" + llDumpList2String(values, "|");
}



default
{
    state_entry()
    {
        list lslonTestList =["foo", <0.5,34.5,3452.5,4.5>, "I wandered lonely as a cloud."];
        string lslonString = "LSLON 1.0\n" + lslon_encodeListForKey(lslonTestList, "testdata", TRUE);
        llOwnerSay("lslon output: " + lslonString);
//        string lslonString = "testdata=TYPED|3|foo|6|<0.5,34.5,3452.5,4.5>|3|I%20wandered%20lonely%20as%20a%20cloud%2E%2E%2E";
        list lslonKeyValue = lslon_parseString2LSLON(lslonString);
        list lslonValue = lslon_valueForKey(lslonKeyValue, "testdata");
        llOwnerSay((string)lslonValue);
    }
}