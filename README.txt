Me contacter via owoxa.com

Plugin en CC-0 - vibe coding avec Grok.

Objectif : Générateur simple de CPT + Taxonomies depuis l’admin WordPress.

Current version > V2.0

> Version 2.0
Menu admin : Owoxa CPT & Tax
Deux onglets très simples (ou deux pages) :
Custom Post Types → liste + ajouter / modifier / supprimer
Taxonomies → liste + ajouter / modifier / supprimer + liaison aux CPT

Champs essentiels uniquement (pas de surcharge)
Enregistrement dynamique au init
Flush des rewrite rules à la sauvegarde

> Version 1.0
Création de la structure, chargement du plugin sur WordPress.

Structure :
owoxa-cpt-tax/
-- owoxa-cpt-tax.php - fichier principal du plugin
-- includes/
--- class-cpt.php - enregistrement dynamique des CPT
--- class-taxonomies.php - enregistrement dynamique des Taxonomies
--- class-admin.php - page d’administration (liste + formulaires)
--- class-storage.php - gestion du stockage (wp_options)
- readme.txt
