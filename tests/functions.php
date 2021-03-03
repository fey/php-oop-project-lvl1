<?php

function str_starts_with($value, $start)
{
    return mb_strpos($value, $start) === 0;
}
