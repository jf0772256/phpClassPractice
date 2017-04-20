<?php
interface Numeric {
  //I think that this will work...
  public function qb_byte($size1to127);
  public function qb_integer($sizetype);
  public function qb_decimal();
  public function qb_double();
  public function qb_boolean();
  public function qb_unsigned();
}
?>
