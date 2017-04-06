<?php
    class Alert
    {
        public $Message = "";
        public $TYPE_OF_ALERT = 0;
        
        const SUCCES_ALERT = 1;
        const DANGER_ALERT = 2;
        const WARNING_ALERT = 3;
        const INFO_ALERT = 4;

        public static function MakeAlert($alert)
        {
            $cssClass = "alert ";
            $typeOfAlert = $alert -> TYPE_OF_ALERT;
            $message  = $alert -> Message;
            $html = '<div class="';

            switch ($typeOfAlert)
            {
                case Alert::SUCCES_ALERT:
                    $cssClass = $cssClass . 'alert-success';
                    break;
                case Alert::DANGER_ALERT:
                    $cssClass = $cssClass . 'alert-danger';
                    break;
                case Alert::WARNING_ALERT:
                    $cssClass = $cssClass . 'alert-warning';
                    break;
                case Alert::INFO_ALERT:
                    $cssClass = $cssClass . 'alert-info';
                    break;
            }

            $html = $html . $typeOfAlert . '">' . $message . '</div>';
            echo $html;
        }
    }
?>