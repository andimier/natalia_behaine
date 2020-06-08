<?php
    $url = "https://zoom.us/oauth/token?grant_type=authorization_code&code=hTAtHmpoQc_q2jGIzNcQoW4kJIsBRhOOQ&redirect_uri=http://www.andimier.com/apitests/meetings/cm.html";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_POST, 1); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Basic WUJISVd3SVRUaktudmpRckhjbDlSdzpEbFh3SEJSREdFWW1ucnNDQUVSSjJ3dTlHNEhCbTIyQQ==")); 

    $data = curl_exec($ch);
    echo $data;

    curl_close($ch); 
?>

<!DOCTYPE html>
<html>
    <div>
        Creando la reunión en Zoom...
    </div>

    <div data-request-data="<?php echo $data; ?>"></div>
    <script>
        
        debugger
    </script>
    <!-- <script src="cm.js"></script> -->
</html>