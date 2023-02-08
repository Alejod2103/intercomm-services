<?php
    if(isset($_GET['address'])){
        //obtiene la informacion del input
        $address = $_GET['address'];

        //crea la url para la peticion a google maps api
        $url = "https://maps.googleapis.com/maps/api/place/autocomplete/json?input=".urlencode($address)."&key=AIzaSyDzVVudx6h_L-GBSz8OM881ajKkXF_RbpE&libraries=places";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);
        curl_close($curl);

        //decodificando a json
        $places = json_decode($response);
        
        $suggestions = "";

        //iterando sobre cada elemento del array para mostrar el elemento
        foreach($places->predictions as $place){
            $suggestions .= "<div>" . $place->description . "</div>";
        }
        echo json_encode(array("sugestions" => $suggestions));
    }
?>