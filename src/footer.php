<footer>
    <p>Bark &copy;2017 by WPAS</p>
</footer>
<?php
    if (isset($conn)) {
        $conn->close();
    }