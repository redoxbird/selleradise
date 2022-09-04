import EmblaCarousel from "embla-carousel";

export default () => ({
  embla: null,
  emblaThumbs: null,
  activeIndex: 0,

  init() {
    window.addEventListener("load", () => {
      this.embla = EmblaCarousel(this.$refs.images, {
        selectedClass: "",
        loop: false,
        skipSnaps: false,
      });

      this.embla.on("select", () => {
        this.setActiveIndex();
        this.emblaThumbs.scrollTo(this.activeIndex);
      });

      if (this.$refs.thumbs) {
        this.emblaThumbs = EmblaCarousel(this.$refs.thumbs, {
          selectedClass: "",
          containScroll: "keepSnaps",
          dragFree: true,
        });
      }
    });

    this.watchVariationChange();
  },

  watchVariationChange() {
    if (!jQuery) {
      return;
    }

    jQuery(".variations_form").on("found_variation", (e, variation) => {
      if (!variation.image) {
        return;
      }

      const variationImageURL = new URL(variation.image.url);

      if (this.embla?.slideNodes()) {
        const slides = this.embla?.slideNodes();

        for (const index in slides) {
          const slide = slides[index];

          if (slide.nodeType !== 1) {
            continue;
          }

          const anchor = slide.querySelector("a");
          const href = anchor.getAttribute("href");

          const url = new URL(variationImageURL.protocol + href);

          if (variationImageURL.pathname === url.pathname) {
            this.embla.scrollTo(index);
            return;
          }
        }

        const slide = this.embla.slideNodes()[0];
        const img = slide?.querySelector("img");
        const anchor = slide?.querySelector("a");

        img?.setAttribute("src", variation.image.src);
        img?.setAttribute("title", variation.image.title);
        img?.setAttribute("alt", variation.image.alt);
        img?.setAttribute("height", variation.image.src_h);
        img?.setAttribute("width", variation.image.src_w);
        anchor?.setAttribute("href", variation.image.full_src);

        slide?.setAttribute("data-size-h", variation.image.src_h);
        slide?.setAttribute("data-size-w", variation.image.src_w);

        img?.addEventListener("load", () => {
          this.embla.scrollTo(0);
        });
      }

      if (this.emblaThumbs?.slideNodes()) {
        const thumb = this.emblaThumbs.slideNodes()[0];
        const thumbImg = thumb?.querySelector("img");

        thumbImg?.setAttribute("src", variation.image.src);
        thumbImg?.setAttribute("height", variation.image.src_h);
        thumbImg?.setAttribute("width", variation.image.src_w);
        thumbImg?.setAttribute("title", variation.image.title);
        thumbImg?.setAttribute("alt", variation.image.alt);
        thumbImg?.setAttribute("data-src", variation.image.full_src);
      }
    });
  },

  onThumbClick(index) {
    if (!this.emblaThumbs.clickAllowed()) return;

    this.embla.scrollTo(index);
  },

  setActiveIndex() {
    this.activeIndex = this.embla.selectedScrollSnap();
  },

  isInView(index) {
    return this.activeIndex === index;
  },
});
