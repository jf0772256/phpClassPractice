# phpClassPractice
 
 This was my first time working with created classes and dub classes in PHP so bear with me.
 
 The code here in is not really meant for use in actual websites as the code is not properly escaped and is suseptable to SQL injection.
 
 The code is built to be run as an administration back end. Here is the point -> it is mostly for practice, working with aspects of classes, inheritence, and other fascits of OOP PHP.
 
 ## The options are that you will find commented code as to what is expected with calling things, most of the query builder code expects arrays. 
 
 When passing values in the builder functions use ['testColumn = "string"'] or ['testColumn = number']. I will continue looking for a way to allow binding values into the queries.
 
 Queries are rarely run in the builder, most are returned to the caller to be then run. 
 
 Queries run in the builder are: Create_newTable, renameTableName, and dropTableByName
    of these queries all do not want the prefix that has been sent to be part of the values passed.
    They all use internal functions to pull the prefix and append it to the table name passed.

## Using the currently under development:

 You should be now able to chain modules, we have added new modules and removed others, please know that If you use this class you will need to use DatabaseClass as well.
 
 I did my best to get the queries as secure as I could make them, using char escaping and error catching to help with development. Note that many new modules allow you to pass a string of single value, or an array of values. Meaning that the following will work:
 
 `$query = $qb->queryStart("create")->ddlStatement("TABLE")->set_table_name("test_Table")->selectColumn_name(["col1 INT UNSIGNED NOT NULL AUTO_INCREMENT","col2 VARCHAR(100) NOT NULL","col3 VARCHAR(25) NOT NULL", "PRIMARY KEY (col1)"])->get_query_string();`
 
 will generate the following SQL query:

 `CREATE TABLE test_Table (col1 INT UNSIGNED NOT NULL AUTO_INCREMENT, col2 VARCHAR(100) NOT NULL, col3 VARCHAR(25) NOT NULL, PRIMARY KEY (col1))`
 
 At this time DDL is the only code that is working at tthis time and I will be working on the rest here, but here are some of the chainable modules that can be used, and note that some will work better than others for certain queries, and I tried to name them as such:
 
 `queryStart($mode)` accepts a string for main sql queries. 
 Accepted values are:
  * SELECT
  * UPDATE
  * DELETE
  * INSERT
  * CREATE
  * DROP
  * ALTER

`ddlStatement($ddl2ndpart)` Basicly completes the DDL statement before we get the table to work on.
Appends the second part of the ddl to the query string and is required for ddl statements.

`set_table_name($tableVar)` Accepts a single table name OR an array of table name strings, parses and escapes values and appends themn to the value to the query string.

`ddlStatement_Alter($alterCommand)` Used when ddl statement is ALTER to set the modeVal variable. Required for ALTER queries.
 Accepted values are:
  * ADD
  * DROP
  * CHANGE
  * MODIFY
  * ALTER
  * RENAME

`ddlStatement_Alter_Next($alterCommand)` Not yet written, is used for SET and DROP commands with the ALTER, ALTER.

`selectColumnName($colName, colDefVal = "")` For going through and appending columns, and column deffinition values to teh query. works best when used with DDL not DML as a special use case module will be written for it. Both incomming params are set up to write either a single string or array of strings, $colDefVal is optional. This function is called in the example above.

For now this is all I have available to go over - I'll create wiki pages for each command and explain in greater detail/

Additional note:: If you are using MariaDB and you use date, dateTime, or CurrentTimestamp -> you will need to set a default value to turn off mariaDB's SQL CURRENT_TIMESTAMP Auto Update.
 
