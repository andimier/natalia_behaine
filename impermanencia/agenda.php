<?php
    require_once('required/cnx.php');
    require_once('crud/rw-slot-data.php');

    if (isset($_GET['product-code'])) {
        $timeSlots = DataSlot::getTimeSlots($_GET['product-code']);
        $product = 'Clases grupales diarias de Meditación';
        $price = $_GET['price'];
        $productType = $_GET['product-type'];
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>datepicker demo</title>
        <link rel="stylesheet" href="css/calenda-ui.css">
        <link href="https://fonts.googleapis.com/css2?family=Arsenal&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Palanquin:wght@100;&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/main.css">
        <script src="http://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="js/calendar-ui.js"></script>
    </head>

    <body>
        <main>
            <header>
                <h1>impermanencia</h1>
                <h4>Natalia Behaine</h4>

                <nav>
                    <ul>
                        <li>inicio / home</li>
                        <li>servicios / services</li>
                        <li>paquetes / packages</li>
                        <li>eventos / events</li>
                    </ul>
                </nav>
            </header>

            <section class="date-picker-wrapper">

                <h4>seleccionaste | you've chosen:</h4>
                <h3><?php echo $product; ?></h3>

                <h4 class="summary-product-price">$ <?php echo $price; ?></h4>
                <p class="summary-product-type">Esta es una clase <?php echo $productType === 'single' ? 'personalizada' : 'grupal'; ?></p>

            </section>

            <section>
                <div class="calendar-wrapper">
                    <div id="datepicker"></div>
                </div>
            </section>

            <section class="available-hours">
                <h3 class="selected-day">
                    escoge una fecha | pick a date
                </h3>

                <div class="hours-wrapper">
                    <div class="slots-message <?php echo empty($timeSlots) ? '' : 'hidden' ?>">
                        <p>sin horas diponibles este día | no available time slots this day</p>
                    </div>

                    <div class="slots-wrapper <?php echo empty($timeSlots) ? 'hidden' : '' ?>">
                        <?php for ($i = 0; $i < count($timeSlots); $i++): ?>
                            <?php if ($timeSlots[$i]['state'] != 'blocked'): ?>
                                <div class="time-slot hidden <?php echo $timeSlots[$i]['state'] == 'free' ? ' free' : ' booked' ?>"
                                    data-product-code="<?php echo $timeSlots[$i]['product_code']?>"
                                    data-slot-type="<?php echo $timeSlots[$i]['type']?>"
                                    data-slot-id="<?php echo $timeSlots[$i]['id']?>"
                                    data-slot-state="<?php echo $timeSlots[$i]['state']?>"
                                    data-slot-date="<?php echo $timeSlots[$i]['date']?>"
                                    data-slot-time="<?php echo $timeSlots[$i]['time']?>"
                                >

                                    <h3>
                                        <?php echo $timeSlots[$i]['time']?>
                                    </h3>

                                </div>
                            <? endif; ?>
                        <?php endfor;?>
                    </div>
                </div>

            </section>

            <section>
                <?php if (!empty($timeSlots)): ?>


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
        </main>

        <script src="js/main.js"></script>
    </body>
</html>

