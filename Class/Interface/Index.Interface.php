<?php
interface Index {
  //I think that this will work...
  public function qb_index($IndexName, $IndexColName);
  public function qb_unique($UniqueColName);
}
?>
