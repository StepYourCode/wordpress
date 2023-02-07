import { __ } from "@wordpress/i18n";
// import { useBlockProps } from "@wordpress/block-editor";
import { useEffect } from "@wordpress/element";

export default ({ attributes: { posts }, setAttributes }) => {
  useEffect(() => {
    const run = async () => {
      const data = await wp.apiFetch({ path: "/rd/hikes" });
      setAttributes({ posts: data });
    };
    run();
  }, []);
  console.log(posts);

  if (!posts) {
    return <p>Loading...</p>;
  }
  if (posts.length === 0) {
    return <p>No hikes scheduled!</p>;
  }

  return posts && <p>Salut</p>;
};

// const posts = select("core").getEntityRecords("postType", "hikes", {
//   per_page: -1,
//   order: "asc",
//   order_by: "meta_value",
//   meta_key: "start_date",
// });
