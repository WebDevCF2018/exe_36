# sélection de toutes les news
SELECT * FROM news;
# sélection des user
SELECT * FROM user;
# sélection des categ
SELECT * FROM categ;
# sélection des permission
SELECT * FROM permission;

# sélection du 'title' et 'content' des 'news' et le 'name' venant de la table 'user'
SELECT n.title, n.content, u.name
	FROM news n
    INNER JOIN user u 
    ON n.user_iduser = u.iduser;
	

# sélection du 'title' et 'content' des 'news' et le 'name' venant de la table 'user' ainsi que le 'name' renommé en 'pname' et le 'level' de la table permission
SELECT n.title, n.content, u.name, p.name AS pname, p.level
	FROM news n
    INNER JOIN user u 
		ON n.user_iduser = u.iduser
    INNER JOIN permission p 
		on u.permission_idpermission = p.idpermission
    ;
    
# sélection de tous les champs de "user", et du "name" renommé "pname" qui ont le level "3" depuis "permission"
SELECT u.*, p.name AS pname 
	FROM user u 
		INNER JOIN permission p 
		ON u.permission_idpermission = p.idpermission
    WHERE p.level=3;

# Sélection de tous les champs de "user" et le "level" de "permission" lorsque "user.login" vaut "edit" et "user.pwd" vaut "edit"
SET @login_user = "user2";
SET @pwd_user = "user2";
SELECT user.*, permission.level
	FROM user 
    INNER JOIN permission
		ON permission.idpermission = user.permission_idpermission
    WHERE user.login=@login_user AND user.pwd=@pwd_user;
    ;
    
# sélection des categ pour le menu (idcateg et name)
SELECT idcateg, name FROM categ;

# Sélection de toutes les "news" (idnews, title, content, publication) LORSQUE "news.visible"=1
SELECT n.idnews, n.title, n.content, n.publication 
	FROM news n
    WHERE n.visible=1;
    
# Sélection de toutes les "news" (idnews, title, 220 caractères de content, publication) LORSQUE "news.visible"=1
SELECT n.idnews, n.title, SUBSTR(n.content, 1, 220) AS content, n.publication 
	FROM news n
    WHERE n.visible=1;
    
# Sélection de toutes les "news" (idnews, title, 220 caractères de content, publication), lien non obligatoire avec "categ" (idcateg,name)  LORSQUE "news.visible"=1
SELECT n.idnews, n.title, SUBSTR(n.content, 1, 220) AS content, n.publication, c.idcateg, c.name 
	FROM news n
		LEFT JOIN news_has_categ h
			ON h.news_idnews = n.idnews
		LEFT JOIN categ c
			ON h.categ_idcateg = c.idcateg
    WHERE n.visible=1;
    
# Sélection de toutes les "news" (idnews, title, 220 caractères de content, publication), lien non obligatoire avec "categ" (idcateg,name => SONT résultats concaténés, idcateg avec une ",", name avec "_€.€_")  LORSQUE "news.visible"=1 le tout groupé par "n.idnews"
SELECT n.idnews, n.title, SUBSTR(n.content, 1, 220) AS content, n.publication, GROUP_CONCAT(c.idcateg) AS idcateg, GROUP_CONCAT(c.name SEPARATOR '_€.€_') AS name 
	FROM news n
		LEFT JOIN news_has_categ h
			ON h.news_idnews = n.idnews
		LEFT JOIN categ c
			ON h.categ_idcateg = c.idcateg
    WHERE n.visible=1
    GROUP BY n.idnews;    


# sélection des détails d'une news
SELECT n.title, n.content, n.publication,
  GROUP_CONCAT(c.idcateg) AS idcateg, 
  GROUP_CONCAT(c.name SEPARATOR '_€.€_') AS categname,
  u.name as username, u.iduser
	      FROM news n
		    LEFT JOIN news_has_categ h
			  ON h.news_idnews = n.idnews
		    LEFT JOIN categ c
			  ON h.categ_idcateg = c.idcateg
			INNER JOIN user u 
				ON n.user_iduser= u.iduser
          WHERE n.visible=1 AND n.idnews=1
            GROUP BY n.idnews;    
    
# sélection d'un utilisateur grâce à son login et mot de passe, avec ses permissions
SELECT u.iduser, u.login, u.name AS username, p.name AS permissionname, p.level
	FROM user u 
	INNER JOIN permission p 
		ON u.permission_idpermission = p.idpermission
	WHERE u.login='admin' AND u.pwd='admin';
    
