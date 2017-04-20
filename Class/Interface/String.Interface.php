<?php
interface StringType {
  //I think that this will work...
  public function qb_char($ColName,$ColLen=1);
  public function qb_string($ColName, $ColLen=1);

}
?>
