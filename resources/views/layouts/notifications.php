 <div id="float_notifications_container">
    &nbsp;
 </div>

 <style>
    #float_notifications_container{
        position:fixed;
        bottom:0px;
        left:0px;
    }
 </style>
        <script>
            $(document).ready(function(){
               // setTimeout(getNotifications,5000);
               setInterval(getLastNotifications,5000);

            });

            //obter notificacoes iniciais
            function getNotifications(){
                     $.get( "http://localhost/trocalivro/books/public/user/notifications", function(resp) {

                         $("#float_notifications_container").html(resp);


                    });

                }

                //funcao que vai executar cada certo tempo definido no inicio
            function getLastNotifications(){
                     $.get( "http://localhost/trocalivro/books/public/user/last_notifications", function(resp) {
                     $("#float_notifications_container").fadeIn('fast');
                         $("#float_notifications_container").html(resp);
                            $(".notification_container").click(function(){

                          //  alert("siii"+$(this).find(".notification_container_inside_type").val());
                            if(!isNaN($(this).find(".notification_container_inside_type").val())){
                                switch(parseInt($(this).find(".notification_container_inside_type").val())){
                                    case 1:
                                    //notifications
                                  /// alert("aquiii");
                                    window.location.assign("/trocalivro/books/public/troca/minhastrocas");//um enderco para olhar os pedidos feitos de outros para mim
                                    break;
                                }

                            }

                         });
                       // setTimeout(fadeNotificationsOut,5000);
                    });

                }

            function fadeNotificationsOut(){
                $("#float_notifications_container").fadeOut('fast');
               // $("#float_notifications_container").html('&nbsp');
            }
        </script>
