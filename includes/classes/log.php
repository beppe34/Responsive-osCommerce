<?php 
    /**
 * Description of log
 *
 * @author Pierre
 */
class log {
    //put your code here
      protected $defaultfilename = "debug.log";
      protected $file = "debug.log";
      protected $path = "";
      
      function __construct($f) {
//echo $_SERVER['DOCUMENT_ROOT'];
          if($f=='') 
            $this->file = $_SERVER['DOCUMENT_ROOT'] . '/catalog/pub/log/' . $this->defaultfilename;
          else
            $this->file = $_SERVER['DOCUMENT_ROOT'] . '/catalog/pub/log/' . $f;

      }

      public function write($text)
      {
          return file_put_contents($this->file,$text . "\n\r" ,LOCK_EX|FILE_APPEND);
      }

      public function writeexeption($exeption){
          $this->write("-EXCEPTION-");
          $this->write(var_export($exeption->getMessage(),true));
          $this->write(var_export($exeption,true));
          $this->write("-END EXCEPTION-");          
      }
      
      public static function w($text){
          $log = new log('');
          return $log->write($text);
      }
      public static function e($exeption){
          $log = new log('');
          return $log->writeexeption($exeption);
      }
}


?>
