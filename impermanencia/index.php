<?php 
    require_once('required/cnx.php');
    require_once('utils/phpfunctions.php');
    require_once('crud/r-schedule.php');

    if (isset($_GET['product-code'])) {
        $timeSlots = getTimeSlots($_GET['product-code']); 
        $product = 'Clases grupales diarias de Meditación';
        $price = 50000;
        $productType = $_GET['product-type'];
    }
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
                    <div class="slots-error-message <?php echo empty($timeSlots) ? '' : 'hidden' ?>">
                        ¡No encontramos citas disponibles para este servicio!
                    </div>
                    
                    <div class="slots-wrapper <?php echo empty($timeSlots) ? 'hidden' : '' ?>">
                        <?php for ($i = 0; $i < count($timeSlots); $i++): ?>
                            <?php if ($timeSlots[$i]['state'] != 'blocked'): ?>
                                <div class="time-wrapper hidden <?php echo $timeSlots[$i]['state'] == 'free' ? ' free' : ' booked' ?>"
                                    data-product-code="<?php echo $timeSlots[$i]['product_code']?>"
                                    data-slot-type="<?php echo $timeSlots[$i]['type']?>"
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
            </div>
        </section>

        <section>
            <h3>Resumen de tu cita</h3>
            <h2>Producto: <?php echo $product; ?></h2>

            <?php if (!empty($timeSlots)): ?>
                <pclass="summary-product-price">$ <?php echo $price; ?></p>
                <p class="summary-product-type">Esta es una clase <?php echo $productType === 'single' ? 'personalizada' : 'grupal'; ?></p>
                <p class="summary-date"></p>
                <p class="summary-time"></p>

                <form action="purchase-gate.php" id="submit-order" class="hidden" method="POST">
                <!-- <form action="" id="submit-order" class="hidden" method="POST"> -->
                    <div id="payer-info">
                        <label class="payer-input payer-name">
                            Tu nombre:
                            <input type="input" class="payer-info-field" name="payerName" />
                        </label>
                        <label class="payer-input payer-email">
                            Tu correo electrónico:
                            <input type="input" class="payer-info-field" name="payerEmail" />
                        </label>
                        <label class="payer-input payer-phone">
                            Tu teléfono:
                            <input type="input" class="payer-info-field" name="payerPhone" />
                        </label>
                    </div>

                    <input class="slot-data" type="hidden" name="product" value="<?php echo $product; ?>"/>
                    <input class="slot-data" type="hidden" name="price" value="<?php echo $price; ?>"/>

                    <input class="slot-data" type="hidden" name="slot-type" value=""/>
                    <input class="slot-data" type="hidden" name="slot-id" value=""/>
                    <input class="slot-data" type="hidden" name="slot-time" value=""/>
                    <input class="slot-data" type="hidden" name="slot-date" value=""/>
            
                    <input type="submit" id="buy-slot" name="make-purchase" value="Comprar"/>
                </form>
            <?php endif; ?>
        </section>

        <script src="js/main.js"></script>
    </body>
</html>

