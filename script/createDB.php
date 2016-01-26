

create table categories (id INTEGER PRIMARY KEY, name varchar(100), parent_id INTEGER);

create table child_categories(id INTEGER, child_id INTEGER, CONSTRAINT unique_child UNIQUE (id,child_id));
