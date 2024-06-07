-- lister les films de kora sortie en 2024
-- tu changes les champs

SELECT f.titre, f.date_sortie
FROM film f
INNER JOIN realisateur r ON f.id_real = r.id_real
WHERE r.nom = 'Kora' AND YEAR(f.date_sortie) = 2024;

-- lister les films de traore sortie en 2024

SELECT f.titre, f.date_sortie
FROM film f
INNER JOIN film_acteur fa ON f.id_film = fa.id_film
INNER JOIN acteur a ON fa.id_act = a.id_act
WHERE a.nom = 'Traore' AND YEAR(f.date_sortie) = 2024;

-- lister les films par rapport a la premiere lettre entree par l'utilisateur
SELECT titre, date_sortie 
FROM film
WHERE LEFT(titre, 1) = 'Lettre_Entree_Utilisateur';

------------------------------------------------------
----------------------------------------------------
SELECT 
    f.titre,
    f.date_sortie,
    f.synopsis,
    f.realisateur
FROM film f
INNER JOIN film_acteur fa ON f.id_film = fa.id_film
INNER JOIN acteur a ON fa.id_act = a.id_act
WHERE a.nom IN ('Nom_Acteur_1', 'Nom_Acteur_2', ...)
  AND f.date_sortie < '2023-04-15'


-----------------------------------------------------------------------
--------------------------------------------------------------------
 --version1: de afficher les films en fonction de la date rentre par l'utilisateur

 SET @date_sortie_utilisateur = '2024-06-13'; -- Remplacez cette valeur par celle saisie par l'utilisateur

SELECT * FROM film
WHERE date_sortie = @date_sortie_utilisateur;


--version2:

SELECT
  id_film,
  titre,
  DATE_FORMAT(date_sortie, '%Y') AS annee_sortie,
  affiche,
  synopsis,
  id_real,
  vu,
  min_film
FROM
  film
WHERE
  DATE_FORMAT(date_sortie, '%Y') = YEAR(STR_TO_DATE(:date_recherche, '%Y'));

--version sans formatage:

SELECT
  id_film,
  titre,
  date_sortie AS annee_sortie,
  affiche,
  synopsis,
  id_real,
  vu,
  min_film
FROM
  film
WHERE
  DATE(date_sortie) = :date_recherche;





