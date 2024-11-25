INSERT INTO gs_an_table (name, mail, naiyou, indate) VALUES('test1', 'aaa@mail.com', 'ないよ！', sysdate());

INSERT INTO gs_publisher (publish_cd, publish_name, indate) VALUES('01', '集英社', sysdate());
INSERT INTO gs_publisher (publish_cd, publish_name, indate) VALUES('02', '翔泳社', sysdate());
INSERT INTO gs_publisher (publish_cd, publish_name, indate) VALUES('03', 'インプレス', sysdate());
INSERT INTO gs_publisher (publish_cd, publish_name, indate) VALUES('04', '技術評論社', sysdate());

INSERT INTO gs_an_table (name, mail, naiyou, indate) VALUES(:name, :mail, :naiyou, sysdate());

SELECT * FROM gs_an_table;
SELECT id, name FROM gs_an_table;

SELECT * FROM gs_an_table WHERE id=2;