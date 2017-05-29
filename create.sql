CREATE TABLE author(
  id INTEGER PRIMARY KEY NOT NULL,
  name VARCHAR(255) NOT NULL
);

CREATE TABLE keyword(
  id INTEGER PRIMARY KEY NOT NULL,
  keyword VARCHAR(255)
);

CREATE TABLE article(
  id INTEGER PRIMARY KEY NOT NULL,
  author_id INTEGER,
  title VARCHAR(255),
  url VARCHAR(500),
  published DATE,
  FOREIGN KEY (author_id) REFERENCES author(id)
);

CREATE TABLE article_keyword(
  article_id INTEGER NOT NULL,
  keyword_id INTEGER NOT NULL,
  weight INTEGER,
  FOREIGN KEY (article_id) REFERENCES article(id),
  FOREIGN KEY (keyword_id) REFERENCES keyword(id),
);
