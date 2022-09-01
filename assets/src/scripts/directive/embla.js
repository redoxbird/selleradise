import emblaCarousel from "embla-carousel";

export default (
  el,
  { value, modifiers, expression },
  { Alpine, effect, cleanup }
) => {
  if (!value) handleRoot(el, Alpine);
  else if (value === "main") handleMain(el, Alpine);
  else if (value === "next") handleNext(el, Alpine);
  else if (value === "prev") handlePrev(el, Alpine);
};

function handleRoot(el, Alpine) {
  Alpine.bind(el, {
    "x-data": () => ({
      embla: null,

      emblaPrev() {
        this.embla?.scrollPrev();
      },

      emblaNext() {
        this.embla?.scrollNext();
      },
    }),
  });
}

function handleMain(el, Alpine) {
  Alpine.bind(el, {
    "x-init"() {
      window.addEventListener("load", () => {
        this.embla = emblaCarousel(el, { loop: false });
      });
    },
  });
}

function handleNext(el, Alpine) {
  Alpine.bind(el, {
    "x-on:click.prevent"(e) {
      this.$data.embla?.scrollNext();
    },
  });
}

function handlePrev(el, Alpine) {
  Alpine.bind(el, {
    "x-on:click.prevent"(e) {
      this.$data.embla?.scrollPrev();
    },
  });
}
