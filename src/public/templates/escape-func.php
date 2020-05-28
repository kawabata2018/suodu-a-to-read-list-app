<?php

function hescape($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

?>