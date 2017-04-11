<?php
// I am hoping to get this to implement the other datatype interfaces.
interface DataType extends DateTime,StringType,Text,Numeric,PrimaryKey,ForeignKey,Index {
  //I think that this will work...
}
?>
