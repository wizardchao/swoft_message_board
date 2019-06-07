<?php
/**
 * Custom global functions
 */

 function getColorList($id){
  $num=$id%10;
  if(in_array($num,[0,1,5,]))  return 'list-group-item list-group-item-success';
  if(in_array($num,[2,6,9,]))  return 'list-group-item list-group-item-info';
  if(in_array($num,[3,7,]))  return 'list-group-item list-group-item-danger';
  if(in_array($num,[4,8,]))  return 'list-group-item list-group-item-warning';
}
