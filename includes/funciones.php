<?php

function debug($variable) : string {
    echo "<pre>";
    print_r($variable);
    echo "</pre>";
    exit;
}

function debugvr($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function ocularAlertas() {
    echo '<script>window.onload=function(){let e=document.querySelectorAll(".alerta");setTimeout(()=>{e.forEach(l=>l.style.display="none")},3e3)};</script>';
}

function lastOne(string $actual, string $ultimo) : bool {
    if ($actual !== $ultimo) {
        return true;
    }
    return false;
}