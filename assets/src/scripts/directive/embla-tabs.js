import EmblaCarousel from "embla-carousel";

export default (
  el,
  { value, modifiers, expression },
  { Alpine, effect, cleanup }
) => {
  if (!value) handleRoot(el, Alpine);
  else if (value === "panels") handlePanels(el, Alpine, modifiers);
  else if (value === "thumbs") handleThumbs(el, Alpine, modifiers);
  else if (value === "thumb") handleThumb(el, Alpine);
  else if (value === "next") handleNext(el, Alpine);
  else if (value === "prev") handlePrev(el, Alpine);
};

function handleRoot(el, Alpine) {
  Alpine.bind(el, {
    "x-data": () => ({
      embla: null,
      emblaThumbs: null,
      activeIndex: 0,

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

      emblaPrev() {
        this.embla?.scrollPrev();
      },

      emblaNext() {
        this.embla?.scrollNext();
      },
    }),
  });
}

function handleThumb(el, Alpine) {
  Alpine.bind(el, {
    "x-on:click.prevent"(e) {
      this.$data.onThumbClick(parseInt(el.dataset.index));
    },
  });
}

function handlePanels(el, Alpine, modifiers) {
  Alpine.bind(el, {
    "x-init"() {
      window.addEventListener("load", () => {
        this.$data.embla = EmblaCarousel(el, {
          selectedClass: "",
          loop: false,
          skipSnaps: false,
          axis: modifierValue(modifiers, "axis", "x"),
        });

        this.$data.embla.on("select", () => {
          this.$data.setActiveIndex();
          this.$data.emblaThumbs.scrollTo(this.$data.activeIndex);
        });
      });
    },
  });
}

function handleThumbs(el, Alpine, modifiers) {
  Alpine.bind(el, {
    "x-init"() {
      window.addEventListener("load", () => {
        this.$data.emblaThumbs = EmblaCarousel(el, {
          selectedClass: "",
          containScroll: "keepSnaps",
          dragFree: true,
          axis: modifierValue(modifiers, "axis", "x"),
        });
      });
    },
  });
}

function handleNext(el, Alpine) {
  Alpine.bind(el, {
    "x-on:click.prevent"(e) {
      this.$data.embla?.emblaNext();
    },
  });
}

function handlePrev(el, Alpine) {
  Alpine.bind(el, {
    "x-on:click.prevent"(e) {
      this.$data.embla?.emblaPrev();
    },
  });
}

function modifierValue(modifiers, key, fallback) {
  if (modifiers.indexOf(key) === -1) return fallback;

  const rawValue = modifiers[modifiers.indexOf(key) + 1];

  if (!rawValue) return fallback;

  return rawValue;
}
