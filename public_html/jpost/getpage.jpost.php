<?php

    $url = "https://www.receitaws.com.br/v1/cnpj/05276978000102";


    $getcnpj = curl_init ();
    curl_setopt($getcnpj, CURLOPT_URL, $url);
    curl_setopt($getcnpj, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($getcnpj);

    curl_close($getcnpj);

    echo $result;
    

