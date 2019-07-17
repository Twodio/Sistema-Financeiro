<?php
    $cnpj = preg_replace("/[^0-9]/", "", $_POST['cnpj']);

    if(!empty($cnpj)){        
        $url = "https://www.receitaws.com.br/v1/cnpj/".$cnpj;


        $getcnpj = curl_init ();
        curl_setopt($getcnpj, CURLOPT_URL, $url);
        curl_setopt($getcnpj, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($getcnpj);

        curl_close($getcnpj);

        echo $result;
    } else
        echo "{\"status\": \"ERROR\", \"message\": \"Digite um cpnj válido\"}";
