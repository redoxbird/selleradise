import EmblaCarousel from "embla-carousel";

export default () => ({
  embla: null,
  emblaThumbs: null,
  activeIndex: 0,

  init() {
    this.initEmbla();
  },

  initEmbla() {
    if (!this.$refs.images || !this.$refs.thumbs) {
      return;
    }

    window.addEventListener("load", () => {
      this.embla = EmblaCarousel(this.$refs.images, {
        selectedClass: "",
        loop: false,
        skipSnaps: false,
      });
      this.emblaThumbs = EmblaCarousel(this.$refs.thumbs, {
        selectedClass: "",
        containScroll: "keepSnaps",
        dragFree: true,
      });
      this.embla.on("select", () => {
        this.setActiveIndex();
        this.emblaThumbs.scrollTo(this.embla.selectedScrollSnap());
      });
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

  emblaPrev() {
    this.embla?.scrollPrev();
  },

  emblaNext() {
    this.embla?.scrollNext();
  },
});
