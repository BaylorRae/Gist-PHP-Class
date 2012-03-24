<?php

include 'lib/gist.php';

$gist = new Gist('1510818', 'search_params.php');

echo $gist->render();
