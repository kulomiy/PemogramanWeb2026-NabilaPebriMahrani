<?php
// Mengamankan output HTML dari data yang berasal dari user/database.
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
