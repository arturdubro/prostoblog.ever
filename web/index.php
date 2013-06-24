<?php
include "lib/db.php";
include "lib/base.php";
new app(substr($_SERVER['REQUEST_URI'],1));