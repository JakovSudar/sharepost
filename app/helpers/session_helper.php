<?php
    session_start();

    //Flash message
    function flash($name='',$message='',$class='alert alert-success'){
        if(!empty($name)){
            //Ako se prvi put unosi poruka
            if(!empty($message) && empty($_SESSION[$name])){
                if(!empty($_SESSION[$name])){
                    unset($_SESSION[$name]);
                }
                if(!empty($_SESSION[$name.'_class'])){
                    unset($_SESSION[$name.'_class']);
                }
                //spremi poruku u varijablu                
                $_SESSION[$name] = $name;
                $_SESSION[$name.'_message']=$message;
                $_SESSION[$name.'_class']=$class;
            }elseif(empty($message) && !empty($_SESSION[$name])){
                $class = !empty($_SESSION[$name.'_class']) ? $_SESSION[$name.'_class'] : '';
                echo '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name.'_message'].'</div>';
                unset($_SESSION[$name]);
                unset($_SESSION[$name.'_class']);

            }

        }
    }

    

    