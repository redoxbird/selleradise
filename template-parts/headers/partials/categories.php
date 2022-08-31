<?php

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

if (isset($args)) {
  extract($args);
}


  // $image = [];
  // $image["id"] = (int) esc_attr(get_term_meta($term->term_id, 'thumbnail_id', true));
  // $image["thumbnail"] = wp_get_attachment_image_src($image["id"], 'thumbnail');
  // $image["alt"] = esc_attr(get_post_meta($image["id"], '_wp_attachment_image_alt', true));


?>

<ul 
  <?php if ($parent) : ?> 
    x-show="activeChild == true" 
    class="m-0 p-0 pl-3 w-full text-sm font-medium border-0 border-l-1 border-solid border-l-zinc-200" 
    x-collapse 
  <?php else : ?> 
    class="m-0 pb-12 w-full text-md min-h-[30rem]" 
  <?php endif; ?>
  >

  <?php foreach ($items as $item):
    $thumbnail_id = get_term_meta($item['term_id'], 'thumbnail_id', true);
    $image = wp_get_attachment_image_src($thumbnail_id, 'thumbnail');
  ?>
    <li class="list-none flex justify-between flex-wrap items-center w-full" x-data="{activeChild: false}">
      <a href="<?php echo $item['url']; ?>" class="flex justify-start items-center flex-1 py-2 my-2 font-primary text-sm font-semibold rounded-full">
        <?php if($image): ?>
          <img
					  class="w-10 h-10 rounded-full mr-3 shrink-0 object-cover"
					  src="<?php echo esc_url(selleradise_get_image_placeholder()); ?>"
						x-lazy:src="<?php echo esc_url($image[0]); ?>"
					  alt="<?php echo esc_attr($item['name']); ?> Image"
          >
        <?php endif; ?>
        <?php echo esc_html($item['name']); ?>
      </a>

      <?php if (isset($item['children']) && !empty($item['children'])) : ?>
        <button class="w-8 h-8 flex justify-center items-center py-2 bg-gray-50 border-1 border-gray-300 rounded-full" x-on:click="activeChild = !activeChild" aria-label="<?php echo esc_html(__("Open", '[TEXT_DOMAIN]') . ' ' . $item['name']); ?>">
          <span x-show="!activeChild" class="w-4 flex justify-center items-center h-auto">
            <?php echo selleradise_svg("tabler-icons/chevron-down"); ?>
          </span>
          <span x-show="activeChild" class="w-4 flex justify-center items-center h-auto">
            <?php echo selleradise_svg("tabler-icons/chevron-up"); ?>
          </span>
        </button>

        <?php
        get_template_part(
          "template-parts/headers/partials/categories",
          null,
          ["items" => $item['children'], "level" => $level + 1, "parent" => $item]
        );
        ?>
      <?php endif; ?>
    </li>
  <?php endforeach; ?>
</ul>