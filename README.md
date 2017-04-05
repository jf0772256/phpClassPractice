# phpClassPractice
 
 This was my first time working with created classes and dub classes in PHP so bear with me.
 
 The code here in is not really meant for use in actual websites as the code is not properly escaped and is suseptable to SQL injection.
 
 The code is built to be run as an administration back end. Here is the point -> it is mostly for practice, working with aspects of classes, inheritence, and other fascits of OOP PHP.
 
 ##The options are that you will find commented code as to what is expected with calling things, most of the query builder code expects arrays. 
 
 When passing values in the builder functions use ['testColumn = "string"'] or ['testColumn = number']. I will continue looking for a way to allow binding values into the queries.
 
 Queries are rarely run in the builder, most are returned to the caller to be then run. 
 
 Queries run in the builder are: Create_newTable, renameTableName, and dropTableByName
    of these queries all do not want the prefix that has been sent to be part of the values passed.
    They all use internal functions to pull the prefix and append it to the table name passed.
