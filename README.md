# 🎓 EduQuiz - Application Full-Stack de Gestion et Passage de Quiz

**EduQuiz** est une application web dynamique et responsive développée en équipe, permettant aux enseignants de créer des quiz et aux étudiants de tester leurs connaissances en saisissant un code d'accès unique.

Le projet est entièrement structuré selon les principes de la **Programmation Orientée Objet (POO)** en PHP, en appliquant le design pattern **Repository** et une séparation stricte entre la logique métier (**Services**) et l'affichage (**Views**).

---

## 🚀 Fonctionnalités Principales

### 👨‍🏫 Interface Enseignant (Dashboard)
* **Authentification sécurisée** par rôles.
* **CRUD Complet des Quiz** : Création, lecture, modification et suppression de quiz.
* **Génération Automatique de Code** : Un code unique à 6 caractères est généré pour chaque quiz.
* **Gestion des Questions** : Ajout de questions et de choix de réponses (vrai/faux) associés.

### 👨‍🎓 Interface Étudiant (Passage du Quiz)
* **Recherche par Code d'Accès** : L'étudiant accède directement au quiz via le code fourni.
* **Interface de Passage Fluide** : Un design moderne, responsive et épuré avec Tailwind CSS.
* **Correction Automatique en Temps Ré Real** : Soumission des réponses, calcul instantané du score et affichage du résultat final.

---

## 🛠️ Stack Technique

* **Backend :** PHP 8 (POO, PDO, Namespaces, Architecture Modulaire).
* **Base de Données :** MySQL / phpMyAdmin.
* **Frontend :** HTML5, JavaScript, Tailwind CSS (Design Moderne & Responsive).
* **Gestion de Version :** Git & GitHub (Collaboration en équipe avec branches).
* **Gestion de Projet :** Trello.

---

## 📂 Architecture du Projet (Structure des Fichiers)

Le projet suit une structure modulaire stricte pour garantir un code propre (`clean code`) et découplé :

```text
EduQuiz-Application-de-Quiz/
│
├── config/
│   └── DB.php                 # Connexion Singleton / PDO à la Base de Données
│
├── public/
│   └── index.php              # Contrôleur Frontal (Front Controller) - Point d'entrée
│
├── src/
│   ├── Entities/              # Classes Modèles (Quiz.php, Question.php...)
│   │
│   ├── Repositories/          # Requêtes SQL pures encapsulées (Fetch en Mode Object 100%)
│   │   └── QuizRepository.php
│   │
│   ├── Services/              # Logique Métier (Génération de code, Calcul des scores...)
│   │   └── QuizService.php
│   │
│   └── Views/                 # Interface Utilisateur (UI)
│       ├── home.php           # Page de saisie du code
│       ├── take_quiz.php      # Formulaire de passage du quiz (Groupement anti-duplication)
│       └── result.php         # Affichage du score final


👥 Notre Équipe :
Jihane Jador;
Achraf OUTAMGHART ;
Mouhamdou Fadal Dramé;
Asma Ennafia;
