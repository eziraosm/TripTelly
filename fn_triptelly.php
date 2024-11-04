<?php
    function generateUserID($length = 8) {
        return bin2hex(random_bytes($length)); // Generates a random string of the specified length
    }
?>