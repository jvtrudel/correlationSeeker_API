<?php

class Fred_Autoloader{

   private $baseDir;

   public function __construct($baseDir = null)
   {
      if ($baseDir === null) {
           $baseDir = dirname(__FILE__);
      }

      // realpath doesn't always work, for example, with stream URIs
      $realDir = realpath($baseDir);
      if (is_dir($realDir)) {
           $this->baseDir = $realDir;
      } else {
           $this->baseDir = $baseDir;
      }
     }

       /**
        * Enregistre notre autoloader
        */
        public static function register($baseDir = null)
        {
            $loader = new self($baseDir);
            spl_autoload_register(array($loader, 'autoload'));

            return $loader;
        }

        public function autoload($class)
        {
            if ($class[0] === '\\') {
                $class = substr($class, 1);
            }
            if (strpos($class, 'fred_api') !== 0) {
                return;
            }

            $file = sprintf('%s/%s.php', $this->baseDir,  $class);
         //   echo $file;
            if (is_file($file)) {
            //    echo $file;
                require $file;
            }
        }
   }
