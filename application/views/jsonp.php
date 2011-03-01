<?php

header('Content-Type: text/javascript; charset=utf8');
print "$callback(" . json_encode($data) . ")";
