import { device } from "../helpers";

export default (el) => {
  return (value) => {
    return device(value);
  };
};
