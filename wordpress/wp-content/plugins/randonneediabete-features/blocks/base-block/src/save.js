import { useBlockProps } from "@wordpress/block-editor";

export default function save() {
  return (
    <p {...useBlockProps.save()}>{"This is a base block in database entry!"}</p>
  );
}
