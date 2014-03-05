<?php
/**
 * Class String
 *
 * This static class tries to implement String.Format
 * by using 2 methods. Both returns the same, however
 * one was made using Regex Patterns
 * 
 * @author pedrocorreia.net
 */
class String{
 
  private static $_str;
 
  /**
   * Format String using Regex Patterns
   *
   * @param String
   * @return String
   */
  public static function Format($str){
 
    self::$_str=$str;
 
    //count arguments that our function received
    $count_args=func_num_args();
    //check if we have sufficient arguments
    if($count_args==1){return $str;}
 
    //find all ocurrences that matches the pattern {(numbers)}
    //and copy them to an auxiliary array named $indexes
    //we'll use PREG_SET_ORDER so that we can get a pair of values
    //with all the matches found,
    //for example: array[y]=array([0]=>"{x}", [1]=>"x");
    preg_match_all('/\{(\d+)\}/',self::$_str, $indexes,PREG_SET_ORDER);
 
    $count=sizeof($indexes);
 
    //looping through our $indexes will give us
    //the elements to replace with
    for($i=0;$i<$count;$i++){
      $arr=$indexes[$i];
 
      //what will we replace, for example {x} (on which x=([0-9]+)
      $replace=$arr[0];
      //get argument value that will replace our {x}
      $arg_pos=$arr[1]+1;
 
      // check if we have a valid argument
      if($arg_pos>-1 && $arg_pos<$count_args){
        //get the argument value
        $arg_value=func_get_arg($arg_pos);
        //replace {x} with the value of specific argument position
        self::$_str=str_replace($replace,$arg_value,self::$_str);
      }
    }
 
    return self::$_str;
 
  }
 
  /**
   * Format String using only str_replace
   *
   * @param String
   * @return String
   */
  public static function FormatSimpler($str){
 
    self::$_str=$str;
 
    //count arguments that our function received
    $count_args=func_num_args();
    //check if we have sufficient arguments
    if($count_args==1){return $str;}
 
    for($i=0;$i<$count_args-1;$i++){
      //get the argument value
      $arg_value=func_get_arg($i+1);
      //replace {$i} with the value of specific argument position
      self::$_str=str_replace("{{$i}}",$arg_value,self::$_str);
    }
 
    return self::$_str;
  }
 
}
 
?>