import "./editor.scss";

import { __ } from "@wordpress/i18n";
import { useBlockProps } from "@wordpress/block-editor";

export default function Edit() {
  return (
    <p {...useBlockProps()}>
      {__("This is a base block in editor", "rd-blocks")}
    </p>
  );
}
