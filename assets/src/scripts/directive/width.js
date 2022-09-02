export default (
  el,
  { value, modifiers, expression },
  { Alpine, effect, cleanup }
) => {
  window.addEventListener(
    "resize",
    Alpine.throttle(() => {
      setWidth();
    }, 500)
  );

  window.addEventListener("selleradise-widget-initialized", (e) => {
    if (!e.detail?.isEdit || !e.detail?.element?.contains(el)) {
      return;
    }

    setWidth();
  });

  Alpine.bind(el, {
    "x-init"() {
      setWidth();
    },
  });

  function setWidth() {
    el.style.setProperty("--width", el.offsetWidth + "px");
  }
};
