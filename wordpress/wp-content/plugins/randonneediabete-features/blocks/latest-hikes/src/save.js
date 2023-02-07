import { useBlockProps } from "@wordpress/block-editor";

export default function save({ attributes: { posts } }) {
  if (!posts) {
    return <p>Loading...</p>;
  }
  if (posts.length === 0) {
    return <p>No hikes scheduled!</p>;
  }

  return (
    <section className={`hikes col-${posts.length}`}>
      {posts.map((post) => {
        const date = new Date(post.start_date).toLocaleDateString("fr-FR");
        const categories = post.hike_types.split(", ");
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
}
