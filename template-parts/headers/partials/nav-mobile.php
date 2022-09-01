<?php

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

if (isset($args)) {
  extract($args);
}

?>

<ul 
  <?php if ($parent) : ?> 
    x-show="activeChild == true" 
    x-collapse 
    class="m-0 p-0 pl-3 w-full text-sm font-medium border-0 border-l-1 border-solid border-l-gray-300" 
  <?php else : ?> 
    class="m-0 pb-12 w-full text-md min-h-[30rem]" 
  <?php endif; ?>
  >
  <?php foreach ($items as $item): ?>
    <li class="list-none flex justify-between flex-wrap items-center w-full <?php echo esc_attr($item->classes); ?>" x-data="{activeChild: '<?php echo $item->activeAncestor ? true : false ?>'}">
      <a
        href="<?php echo esc_url($item->url); ?>"
        title="<?php echo esc_attr($item->title); ?>"
        target="<?php echo esc_attr($item->target); ?>"
        class="block flex-1 py-2 px-4 my-2 font-primary font-semibold text-sm rounded-full <?php echo esc_attr($item->active ? 'bg-gray-100' : ''); ?>">
        <?php echo $item->label; ?>
      </a>

      <?php if ($item->children) : ?>
        <button class="w-8 h-8 flex justify-center items-center py-2 bg-gray-50 border-1 border-gray-300 rounded-full" x-on:click="activeChild = !activeChild" aria-label="<?php echo esc_html(__("Open", '[TEXT_DOMAIN]') . ' ' . $item->label); ?>">
          <span x-show="!activeChild" class="w-4 flex justify-center items-center h-auto">
            <?php echo selleradise_svg("tabler-icons/chevron-down"); ?>
          </span>
          <span x-show="activeChild" class="w-4 flex justify-center items-center h-auto">
            <?php echo selleradise_svg("tabler-icons/chevron-up"); ?>
          </span>
        </button>

        <?php
        get_template_part(
          "template-parts/headers/partials/nav",
          "mobile",
          ["items" => $item->children, "level" => $level + 1, "parent" => $item]
        );
        ?>
      <?php endif; ?>
    </li>
  <?php endforeach; ?>
</ul>