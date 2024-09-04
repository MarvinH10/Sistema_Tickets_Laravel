<?php

function usuarioCorreo($correo)
{
  return strtok($correo, '@');
}
