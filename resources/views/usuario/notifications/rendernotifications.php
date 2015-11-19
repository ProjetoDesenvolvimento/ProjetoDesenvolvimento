<?php

    $respuesta="";
    $counter=0;
    foreach($notificationsresp as $notification){

        switch($notification["object"]->tipo){
            case 1:
                $respuesta.="<div class='notification_container'>";
                $respuesta.="   <div class='notification_container_inside'>";
                $respuesta.="       <span class='notification_container_inside_title'><a href='' class='origin_emaillink'>".$notification["sourcedata"]."</a> esta interesado em seu livro <span>";
                $respuesta.="           <hr>";
                $respuesta.="       <div class='notification_container_inside_body'>".$notification["object"]->texto."</div>";
                $respuesta.="       <div class='notification_container_inside_date'>Data: ".$notification["object"]->created_at."</div>";
                $respuesta.="       <input class='notification_container_inside_id' type='hidden' value='".$notification["object"]->id."'>";
                $respuesta.="       <input class='notification_container_inside_type' type='hidden' value='".$notification["object"]->tipo."'>";
                $respuesta.="   </div>";
                $respuesta.="</div>";
                $counter++;
            break;
             case 2:
                $respuesta.="<div class='notification_container'>";
                $respuesta.="   <div class='notification_container_inside'>";
                $respuesta.="       <span class='notification_container_inside_title'><a href='' class='origin_emaillink'>Solicitacao aceitada<span>";
                $respuesta.="           <hr>";
                $respuesta.="       <div class='notification_container_inside_body'>".$notification["object"]->texto."</div>";
                $respuesta.="       <div class='notification_container_inside_date'>Data: ".$notification["object"]->created_at."</div>";
                $respuesta.="       <input class='notification_container_inside_id' type='hidden' value='".$notification["object"]->id."'>";
                $respuesta.="       <input class='notification_container_inside_type' type='hidden' value='".$notification["object"]->tipo."'>";
                $respuesta.="   </div>";
                $respuesta.="</div>";
                $counter++;
            break;

        }



    }

    echo $respuesta;

?>

    <style>
        .notification_container{
            max-width:300px;
            border:solid 2px gray ;
            padding:5px;
            border-radius: 15px 0 15px 0;
            background-color:rgb(82, 200, 218);
        }
        .notification_container:hover{
            cursor:pointer;
        }
        .origin_emaillink{
            font-weight:900;
            color:green;
        }
    </style>
