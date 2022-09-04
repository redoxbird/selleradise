import Alpine from "alpinejs";
import intersect from "@alpinejs/intersect";
import collapse from "@alpinejs/collapse";
import focus from "@alpinejs/focus";
import * as TwindShim from "twind/shim";

import miniCart from "./store/mini-cart";
import mobileMenu from "./store/mobile-menu";
import toast from "./store/toast";
import scroll from "./store/scroll";

import tooltip from "./directive/tooltip";
import embla from "./directive/embla";
import lazy from "./directive/lazy";
import emblaTabs from "./directive/embla-tabs";
import width from "./directive/width";

import setSrc from "./magic/setSrc";
import device from "./magic/device";

import addToCart from "./data/add-to-cart";
import header from "./data/header";
import searchBar from "./data/search-bar";
import filters from "./data/filters";
import backToTop from "./data/back-to-top";
import productCard from "./data/product-card";
import quantityInput from "./data/quantity-input";
import saleTimer from "./data/sale-timer";
import infiniteScroll from "./data/infinite-scroll";
import faqs from "./data/faqs";
import productPage from "./data/product-page";

import { selleradise } from "./selleradise";
import { default as TwindConfig } from "./config/twind";

window.Alpine = Alpine;
window.Twind = TwindShim;

// Plugins
window.Alpine.plugin(intersect);
window.Alpine.plugin(collapse);
window.Alpine.plugin(focus);

// Store
window.Alpine.store("miniCart", miniCart);
window.Alpine.store("mobileMenu", mobileMenu);
window.Alpine.store("toast", toast);
window.Alpine.store("scroll", scroll);

// Directives
window.Alpine.directive("tooltip", tooltip);
window.Alpine.directive("embla", embla);
window.Alpine.directive("lazy", lazy);
window.Alpine.directive("embla-tabs", emblaTabs);
window.Alpine.directive("width", width);

// Magic properties
window.Alpine.magic("setSrc", setSrc);
window.Alpine.magic("device", device);

// Data
window.Alpine.data("header", header);
window.Alpine.data("addToCart", addToCart);
window.Alpine.data("searchBar", searchBar);
window.Alpine.data("shopFilters", filters);
window.Alpine.data("backToTop", backToTop);
window.Alpine.data("productCard", productCard);
window.Alpine.data("quantityInput", quantityInput);
window.Alpine.data("saleTimer", saleTimer);
window.Alpine.data("infiniteScroll", infiniteScroll);
window.Alpine.data("faqs", faqs);
window.Alpine.data("productPage", productPage);

// Initiate twind
window.TwindConfig = TwindConfig;
window.Twind.setup(window.TwindConfig);
window.Twind.disconnect();

// Initiate selleradise
window.Selleradise = selleradise();
window.Selleradise.focusSource();
window.Selleradise.lazyLoad();
window.Selleradise.smoothScroll();
window.Selleradise.categoriesInProductPageLoop();
window.Selleradise.productPageTabs();
window.Selleradise.scrollTrigger();

// Initiate alpine
window.Alpine.start();

window.addEventListener("selleradise-widget-initialized", (e) => {
  if (!e.detail?.isEdit) {
    return;
  }

  window.Twind.setup({
    ...window.TwindConfig,
    target: e.detail?.element || document.documentElement,
  });

  window.Twind.disconnect();
});
