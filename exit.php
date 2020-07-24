<?php
session_start();
include ("blocks/bd.php");
session_destroy();
echo
("
<script type='text/javascript'>
document.location.href = 'index.php';
</script>
");
?>