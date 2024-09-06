<?php
// Check if form and action are set
if (isset($whatsapp_connected)&&!empty($whatsapp_connected)&&$whatsapp_connected==0) {
    echo '<div class="alert alert-warning">';
    echo "<h1>Warning</h1>";
    echo "<p>Your whatsapp server is not connected. Please connect to allow CRM to work properly.</p>";
    echo "<p><a href='/whatsapp_manage'>Connect WhatsApp</a></p>";
    echo '</div>';
}
?>