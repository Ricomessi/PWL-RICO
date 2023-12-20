<?php
// Verify GD extension
if (extension_loaded('gd')) {
    echo 'GD is enabled on your server.';
} else {
    echo 'GD is not enabled on your server.';
}
