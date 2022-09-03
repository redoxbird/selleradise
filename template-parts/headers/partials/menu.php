<?php

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

if ($args) {
  extract($args);
}

$selleradise_menu = selleradise_get_menu_tree("primary");

?>
<nav role="navigation" aria-label="Primary" class="hidden lg:block pr-4">
  <?php
  if ($selleradise_menu && !empty($selleradise_menu)) :
    get_template_part("template-parts/headers/partials/nav", null, ["items" => $selleradise_menu, "level" => 1, "parent" => []]);
  endif;
  ?>
</nav>