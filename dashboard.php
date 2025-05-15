
<?php
require_once './includes/database.php';
require_once './includes/check_login.php';
require_once './models/user.php';
require_once './models/event.php';
require_once './models/inscription.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$user = getUserById($user_id);

if (!$user) {
    // utilisateur non trouvé, logout ou rediriger
    header('Location: logout.php');
    exit();
}

$prenom = !empty($user['prenom']) ? htmlspecialchars($user['prenom']) : 'Utilisateur';
$role = isset($user['role']) ? strtolower(trim($user['role'])) : 'user';

$mesEvents = getEventsByCreateur($user_id);
$mesInscriptions = getInscriptionsByUser($user_id);
?>

<?php include './includes/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Bienvenue, <?= $prenom ?> 👋</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Profil utilisateur -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <h2 class="text-xl font-semibold text-indigo-600">Profil</h2>
            <img src="uploads/<?= htmlspecialchars($user['image_profil']) ?>" alt="Photo de profil" class="w-24 h-24 rounded-full my-4 object-cover">
            <p class="text-gray-600">Nom : <?= htmlspecialchars($user['nom']) ?></p>
            <p class="text-gray-600">Email : <?= htmlspecialchars($user['email']) ?></p>
            <a href="edit_profile.php" class="text-indigo-500 hover:underline text-sm mt-2 inline-block">Modifier mon profil</a>
        </div>

        <!-- Mes événements créés -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <h2 class="text-xl font-semibold text-indigo-600">Mes événements créés</h2>
            <ul class="list-disc ml-5 mt-3 text-gray-700">
                <?php if (empty($mesEvents)): ?>
                    <li>Aucun événement créé pour le moment.</li>
                <?php else: ?>
                    <?php foreach ($mesEvents as $event): ?>
                        <li><?= htmlspecialchars($event['titre']) ?> (<?= htmlspecialchars($event['date_event']) ?>)</li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
            <a href="create_event.php" class="mt-4 inline-block text-white bg-green-500 hover:bg-green-600 px-4 py-2 rounded-xl">Créer un événement</a>
        </div>

        <!-- Mes inscriptions -->
        <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
            <h2 class="text-xl font-semibold text-indigo-600">Mes inscriptions</h2>
            <ul class="list-disc ml-5 mt-3 text-gray-700">
                <?php if (empty($mesInscriptions)): ?>
                    <li>Aucune inscription pour le moment.</li>
                <?php else: ?>
                    <?php foreach ($mesInscriptions as $insc): ?>
                        <li><?= htmlspecialchars($insc['titre']) ?> - <?= htmlspecialchars($insc['statut']) ?></li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <!-- Espace admin -->
    <?php if ($role === 'admin'): ?>
        <div class="mt-10">
            <h2 class="text-2xl font-bold text-red-600 mb-4">Espace Administration</h2>
            <div class="flex flex-col md:flex-row gap-4">
                <a href="admin_panel.php" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-xl text-center">
                    Gérer la plateforme
                </a>
            </div>
        </div>
    <?php endif; ?>

    <!-- Événements à venir (inscriptions) -->
    <div class="mt-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Mes événements à venir</h2>
        <ul class="list-disc ml-5 mt-3 text-gray-700">
            <?php if (empty($mesInscriptions)): ?>
                <li>Aucun événement à venir.</li>
            <?php else: ?>
                <?php foreach ($mesInscriptions as $insc): ?>
                    <li><?= htmlspecialchars($insc['titre']) ?> - <?= htmlspecialchars($insc['statut']) ?></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</div>

<?php include './includes/footer.php'; ?>
