<?php

namespace Source\Console\Features;

use Source\Api\Telegram\Messanger as Dispatch;

class Boot{

    public function __construct(private Dispatch $dispatch){
    }

    public function dispatch(){

        $this->dispatch->send(str_replace("    ", "","
            *Mensagem:*```php INICIALIZADO ```
            *Project:*```php ".getenv("PROJECT")." ```
            *channel:*```php ".getenv("CHANNEL")." ```
            *Data:*```php ". date("Y-m-d H:i:s") . " ```
            *server:*```php ". json_encode($this->getData()) . " ```"
        ));
    }

    public function getData(){
        return [
           "PROCESSOR_ARCHITECTURE" => $_SERVER["PROCESSOR_ARCHITECTURE"] ?? null,
           "PROCESSOR_IDENTIFIER" => $_SERVER["PROCESSOR_IDENTIFIER"] ?? null,
           "HOST_IPV4" => gethostbyname(gethostname()?? ""),
           "OS" => php_uname('s'),
           "SERIAL_NUMBER" => shell_exec($this->getBaseFoundation())
        ];
    }

    private function getBaseFoundation(){
        
         if(strpos(strtolower(php_uname('s')), 'windows') !== false) {
             return 'wmic bios get serialnumber | sed -n "2p"';
         }

         return  'lshw -class system | grep serial';
    }

}