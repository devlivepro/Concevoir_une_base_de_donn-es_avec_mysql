SELECT m.nom_menu, a.jour
FROM achete a
JOIN menu m ON a.id_menu = m.id_menu
WHERE a.id_client = 1;
