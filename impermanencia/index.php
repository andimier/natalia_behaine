<?php 
    require_once('crud/r-schedule.php'); 
    $timeSlots = getTimeSlots(); 
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>datepicker demo</title>
        <link rel="stylesheet" href="css/calenda-ui.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="http://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="js/calendar-ui.js"></script>
    </head>

    <body>
        <h1>Titulo</h1>

        <section class="date-picker-wrapper">
            <div class="calendar-wrapper">
                <div id="datepicker"></div>
            </div>

            <div class="available-hours">
                <h3 class="selected-day">
                    Mayo 13 2020
                </h3>

                <div class="hours-wrapper">
                    <?php for ($i = 0; $i < count($timeSlots); $i++): ?>
                        <?php if ($timeSlots[$i]['state'] != 'blocked'): ?>
                            <div class="time-wrapper hidden <?php echo $timeSlots[$i]['state'] == 'free' ? ' free' : ' booked' ?>"
                                data-slot-id="<?php echo $timeSlots[$i]['id']?>"
                                data-slot-state="<?php echo $timeSlots[$i]['state']?>"
                                data-slot-date="<?php echo $timeSlots[$i]['date']?>" 
                                data-slot-time="<?php echo $timeSlots[$i]['time']?>">
                                <p class="time">
                                    <?php echo $timeSlots[$i]['time']?>
                                </p>
                            </div>
                        <? endif; ?>
                    <?php endfor;?>
                </div>
            </div>
        </section>

        <section>
            <h2>Resumen de tu cita</h2>
            <p>Producto: Clases grupales diarias de Meditación</p>
            <p class="summary-date"></p>
            <p class="summary-time"></p>

            <div class="payer-info">
                <label class="payer-input payer-name">
                    Tu nombre:
                    <input type="input" name="payer-name" />
                </label>
                <label class="payer-input payer-email">
                    Tu correo electrónico:
                    <input type="input" name="payer-email" />
                </label>
                <label class="payer-input payer-phone">
                    Tu teléfono:
                    <input type="input" name="payer-phone" />
                </label>
            </div>

            <form action="purchase-gate.php" class="submit-order hidden" method="POST">
                <input class="slot-data" type="hidden" name="slot-id" value=""/>
                <input class="slot-data" type="hidden" name="slot-time" value=""/>
                <input class="slot-data" type="hidden" name="slot-date" value=""/>
         
                <input type="submit" name="make-purchase" value="Comprar"/>
            </form>
        </section class="summary">

        <script src="js/main.js"></script>
    </body>
</html>

