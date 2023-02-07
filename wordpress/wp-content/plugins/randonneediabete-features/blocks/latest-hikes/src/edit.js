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

  if (!posts) {
    return <p>Loading...</p>;
  }
  if (posts.length === 0) {
    return <p>No hikes scheduled!</p>;
  }

  return (
    <section className="hikes">
      {posts.map((post) => {
        const date = new Date(post.start_date).toLocaleDateString("fr-FR");
        const categories = post.hike_types.split(",");
        return (
          <a href={post.guid}>
            <article>
              <div className="img">
                <figure>
                  <img
                    src={post.image}
                    alt={`Image de notre prochaine randonnée ${post.post_title}`}
                  />
                </figure>
                <ul className="categories">
                  {categories.map((cat) => (
                    <li
                      className={
                        cat === "Journée" ? "day" : cat === "Semaine" && "week"
                      }
                    >
                      {cat}
                    </li>
                  ))}
                </ul>
              </div>
              <div className="content">
                <span>
                  {date} • {post.town}
                </span>
                <h4>{post.post_title}</h4>
                <a href={post.guid} className="btn">
                  En savoir plus
                </a>
              </div>
            </article>
          </a>
        );
      })}
    </section>
  );
};

// const posts = select("core").getEntityRecords("postType", "hikes", {
//   per_page: -1,
//   order: "asc",
//   order_by: "meta_value",
//   meta_key: "start_date",
// });
