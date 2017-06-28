<?php 
    /**
 * Description of log
 *
 * @author Pierre
 */
class logg {
    //put your code here
      protected $defaultfilename = "admin.log";
      protected $file = "admin.log";
      protected $path = "";
      
      function __construct($f) {
//echo $_SERVER['DOCUMENT_ROOT'];
          if($f=='') 
            $this->file = $_SERVER['DOCUMENT_ROOT'] . '/../log/' . $this->defaultfilename;
          else
            $this->file = $_SERVER['DOCUMENT_ROOT'] . '/../log/' . $f;

      }

      public function write($text)
      {
          return file_put_contents($this->file,date("y-m-d H:i:s") . "|" . $_SERVER['REMOTE_ADDR'] . "| " . $text . "\n\r" ,LOCK_EX|FILE_APPEND);
      }

      public function writeexeption($exeption){
          $this->write("-EXCEPTION-");
          $this->write(var_export($exeption->getMessage(),true));
          $this->write(var_export($exeption,true));
          $this->write("-END EXCEPTION-");          
      }
      
      public static function w($text){
          $log = new logg('');
          return $log->write($text);
      }
      public static function e($exeption){
          $log = new logg('');
          return $log->writeexeption($exeption);
      }
}


?>
