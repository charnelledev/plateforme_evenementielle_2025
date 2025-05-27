<?php
require_once 'includes/database.php';
require_once 'includes/header.php';

// Récupérer les événements actifs
$events = $pdo->query("SELECT * FROM events WHERE statut = 'actif' ORDER BY date_event ASC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="./src/output.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

  
</head>
<body>

    
  <div class="bg-white shadow-lg rounded-2xl overflow-hidden hover:shadow-xl  transition">
    <div class="overflow-hidden">
      <img src="assets/images/87d9c225-305f-4dcb-b1ca-aa36cf8bd4c6.jpg" alt="Conférences"
           class="w-full h-80 object-cover transform transition-all duration-500 hover:scale-110 hover:blur-sm">
    </div>
    <div class="p-6">
      <h2 class="text-2xl font-semibold text-indigo-700">Conférence du personelle</h2>
      <p class="mt-2 text-gray-600">
        Participez à des conférences métiers, panels d'experts et discussions sur les dernières innovations.
      </p>
    </div>
  </div>

<section class="bg-gradient-to-r from-indigo-50 to-blue-100 py-16">
  <div class="text-center mb-12">
    <h1 class="text-4xl font-bold text-indigo-700">Bienvenue sur Événement_2025</h1>
    <p class="text-gray-600 mt-4 max-w-2xl mx-auto">
      Une plateforme moderne pour découvrir, créer et participer à une variété d’événements passionnants partout et en ligne.
    </p>
  </div>

  <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

    <!-- Conférences professionnelles -->


    <div class="bg-white shadow-lg rounded-2xl overflow-hidden hover:shadow-xl  transform transition-all duration-500 hover:scale-110">
      <div class="overflow-hidden">
        <img src="assets/images/Corporate Events Services.jpg" alt="Conférences" class="w-full h-52 object-cover transform transition-all duration-500 hover:scale-110 hover:blur-sm">
      </div>
      <div class="p-6">
        <h2 class="text-2xl font-semibold text-indigo-700">Conférences professionnelles</h2>
        <p class="mt-2 text-gray-600">Participez à des conférences métiers, panels d'experts et discussions sur les dernières innovations.</p>
      </div>
    </div>

    <!-- Concerts ou festivals -->
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden hover:shadow-xl transform transition-all duration-500 hover:scale-110">
      <div class="overflow-hidden">
        <img src="assets/images/téléchargement (68).jpg" alt="Concerts" class="w-full h-52 object-cover transition duration-300 hover:scale-110 hover:blur-sm">
      </div>
      <div class="p-6">
        <h2 class="text-2xl font-semibold text-indigo-700">Concerts & Festivals</h2>
        <p class="mt-2 text-gray-600">Vibrez au rythme des plus grands artistes locaux et internationaux lors de festivals inoubliables.</p>
      </div>
    </div>

    <!-- Webinaires et séminaires -->
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden hover:shadow-xl  transform transition-all duration-500 hover:scale-110">
      <div class="overflow-hidden">
        <img src="assets/images/Dans notre dernier article, nous abordons comment….jpg" alt="Webinaires" class="w-full h-52 object-cover transition duration-300 hover:scale-110 hover:blur-sm">
      </div>
      <div class="p-6">
        <h2 class="text-2xl font-semibold text-indigo-700">Webinaires & Séminaires</h2>
        <p class="mt-2 text-gray-600">Rejoignez nos séminaires en ligne depuis chez vous pour apprendre, échanger et progresser.</p>
      </div>
    </div>

    <!-- Salons / Foires -->
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden hover:shadow-xl transform transition-all duration-500 hover:scale-110 ">
      <div class="overflow-hidden">
        <img src="assets/images/f6a7b843-341a-4679-833a-5c8174131f38.jpg" alt="Salon" class="w-full h-52 object-cover transition duration-300 hover:scale-110 hover:blur-sm">
      </div>
      <div class="p-6">
        <h2 class="text-2xl font-semibold text-indigo-700">Salons & Foires</h2>
        <p class="mt-2 text-gray-600">Explorez nos salons culturels, technologiques et foires commerciales dans plusieurs régions.</p>
      </div>
    </div>

    <!-- Événements associatifs ou scolaires -->
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden hover:shadow-xl  transform transition-all duration-500 hover:scale-110">
      <div class="overflow-hidden">
        <img src="assets/images/A student of Glenmuir High School speaks at a….jpg" alt="Événement associatif" class="w-full h-52 object-cover transform transition-all duration-500 hover:scale-110 hover:blur-sm">
      </div>
      <div class="p-6">
        <h2 class="text-2xl font-semibold text-indigo-700">Événements associatifs & scolaires</h2>
        <p class="mt-2 text-gray-600">Engagez-vous dans des événements communautaires, journées culturelles, activités scolaires.</p>
      </div>
    </div>

    <!-- Formations ou ateliers -->
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden hover:shadow-xl  transform transition-all duration-500 hover:scale-110">
      <div class="overflow-hidden">
        <img src="assets/images/Team building artistique _ création d'une fresque….jpg" alt="Formation" class="w-full h-52 object-cover transition duration-300 hover:scale-310 hover:blur-sm">
      </div>
      <div class="p-6">
        <h2 class="text-2xl font-semibold text-indigo-700">Formations & Ateliers</h2>
        <p class="mt-2 text-gray-600">Améliorez vos compétences grâce à nos sessions pratiques, ateliers techniques et formations intensives.</p>
      </div>
    </div>

  </div>
</section>


<?php require_once 'includes/footer.php'; ?>

        </body>
        </html>