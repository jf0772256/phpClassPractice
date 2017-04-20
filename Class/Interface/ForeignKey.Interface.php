<?php
interface ForeignKey{
  //I think that this will work...
  public function qb_foreign($RefKey, $AssocTableName, $AssocKey);
}
?>
