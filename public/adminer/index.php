<?php
/*
function adminer_object()
{
  // required to run any plugin

  include_once "./plugins/plugin.php";

  // autoloader

  foreach (glob("plugins/*.php") as $filename)
  {
    include_once "./$filename";
  }

  $plugins = [
    // specify enabled plugins here
    new AdminerDumpAlter,
    // AdminerTheme has to be the last one!
    new AdminerTheme("default-blue"),
  ];

  return new AdminerPlugin($plugins);

}
*/
// include original Adminer or Adminer Editor
include "./adminer.php";
