CREATE PROCEDURE coauthorproc(IN fitstname VARCHAR, IN lastname VARCHAR)
	BEGIN
		SELECT s1.* FROM paper_author WHERE s1.title IN(SELECT s2.title FROM paper_author WHERE s2.author_firstname = firstname AND s2.author_lastname = lastname);
	END//