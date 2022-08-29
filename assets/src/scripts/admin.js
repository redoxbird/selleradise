import { calculateContrastRatio, hexToRgb } from "./helpers";

function getContrastingColor(value, candidate1, candidate2) {
  const types = [
    typeof value == "string",
    typeof candidate1 == "string",
    typeof candidate2 == "string",
  ].join(",");

  switch (types) {
    case "true,true,false":
    case "false,true,false":
      return candidate1;
    case "true,false,true":
    case "false,false,true":
    case "false,true,true":
      return candidate2;
    case "true,false,false":
    case "false,false,false":
      return;
  }

  const rgb1 = hexToRgb(value);
  const rgb2 = hexToRgb(candidate1);

  if (!rgb1 || !rgb2) {
    return candidate1;
  }

  const contrastRatio = calculateContrastRatio(rgb1, rgb2);
  return contrastRatio >= 4.5 ? candidate1 : candidate2;
}

wp.customize(
  "color_text",
  "color_background",
  "color_main",
  "color_main_text",
  function (color_text, color_background, color_main, color_main_text) {
    color_main.bind(function (value) {
      const text_color = getContrastingColor(
        value,
        color_background.get(),
        color_text.get()
      );

      if (text_color) {
        color_main_text.set(text_color);
      }
    });
  }
);

wp.customize(
  "color_text",
  "color_background",
  "color_accent_light",
  "color_accent_light_text",
  function (
    color_text,
    color_background,
    color_accent_light,
    color_accent_light_text
  ) {
    color_accent_light.bind(function (value) {
      const text_color = getContrastingColor(
        value,
        color_background.get(),
        color_text.get()
      );

      if (text_color) {
        color_accent_light_text.set(text_color);
      }
    });
  }
);
