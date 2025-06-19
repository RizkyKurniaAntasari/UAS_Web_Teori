<?php
session_start();
require_once '../../db.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$pageTitle = "Pengaturan Jadwal";
$currentPage = "pengaturan";
$success_message = '';
$error_message = '';

$slot_jadwal_list = [];

try {
    $pdo = get_pdo_connection();

    $stmt_slots = $pdo->query("SELECT * FROM slot_jadwal ORDER BY tanggal DESC, pukul ASC");
    $slot_jadwal_list = $stmt_slots->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $error_message = 'Database Error: ' . $e->getMessage();
    error_log("Pengaturan fetch error: " . $e->getMessage());
}

require __DIR__ . '/components/html_head.php';
?>
<style type="text/tailwindcss">
    @layer components {
        .form-input-settings {
            @apply w-full px-4 py-2.5 bg-gray-700 border border-gray-600 text-gray-200 rounded-lg 
                   focus:ring-1 focus:ring-secondary focus:border-secondary 
                   placeholder-gray-400 transition-colors duration-200;
        }
    }
</style>

<body class="bg-primary text-gray-300">
    
    <?php require __DIR__ . '/components/admin_header.php'; ?>

    <div class="flex min-h-screen pt-[68px] sm:pt-[72px]"> 
        
        <?php require __DIR__ . '/components/admin_sidebar.php'; ?>

        <main class="flex-1 p-6 sm:p-8 bg-gray-900 md:ml-64">
            <div class="bg-gray-800 p-6 sm:p-8 rounded-xl shadow-lg min-h-full">
                <h1 class="text-2xl sm:text-3xl font-semibold text-gray-100 mb-8">Pengaturan Jadwal</h1>

                <?php if ($success_message): ?>
                    <div class="bg-green-900/70 border border-green-700 text-green-300 px-4 py-3 rounded-md mb-6 text-sm" role="alert">
                        <span><?php echo $success_message; ?></span>
                    </div>
                <?php endif; ?>

                <?php if ($error_message): ?>
                    <div class="bg-red-900/70 border border-red-700 text-red-300 px-4 py-3 rounded-md mb-6 text-sm" role="alert">
                        <strong class="font-bold">Kesalahan!</strong>
                        <span><?php echo $error_message; ?></span>
                    </div>
                <?php endif; ?>

                <div class="mt-10 bg-gray-800 p-6 sm:p-8 rounded-xl shadow-lg">
                    <h2 class="text-xl font-semibold text-gray-100 mb-6 border-b border-gray-600 pb-4">Kelola Jadwal Tersedia</h2>
                    <form id="form-add-slot" class="space-y-4 mb-8">
                        <input type="hidden" name="action" id="slot-action" value="create">
                        <input type="hidden" name="id" id="slot-id">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="slot-jenis-jadwal" class="block text-sm font-medium text-gray-300 mb-2">Jenis Jadwal</label>
                                <select name="jenis_jadwal" id="slot-jenis-jadwal" required class="form-input-settings">
                                    <option value="" disabled selected>Pilih Jenis Jadwal</option>
                                    <option value="Jadwal Awal">Jadwal Awal</option>
                                    <option value="Jadwal Wawancara">Jadwal Wawancara</option>
                                    <option value="Jadwal Istirahat">Jadwal Istirahat</option>
                                    <option value="Jadwal Akhir">Jadwal Akhir</option>
                                </select>
                            </div>
                            <div>
                                <label for="slot-tanggal" class="block text-sm font-medium text-gray-300 mb-2">Tanggal</label>
                                <input type="date" name="tanggal" id="slot-tanggal" required class="form-input-settings">
                            </div>
                            <div>
                                <label for="slot-pukul" class="block text-sm font-medium text-gray-300 mb-2">Pukul</label>
                                <input type="time" name="pukul" id="slot-pukul" required class="form-input-settings">
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm font-medium text-gray-300">Status Slot:</span>
                            <div class="flex items-center space-x-2">
                                <input type="radio" id="status-dibuka" name="status" value="Dibuka" class="form-checkbox" checked>
                                <label for="status-dibuka" class="text-gray-300">Dibuka</label>
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="radio" id="status-ditutup" name="status" value="Ditutup" class="form-checkbox">
                                <label for="status-ditutup" class="text-gray-300">Ditutup</label>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-3">
                            <button type="button" id="btn-cancel-slot" class="px-6 py-2.5 rounded-button text-gray-300 bg-gray-600 hover:bg-gray-700 hidden">Batal Edit</button>
                            <button type="submit" id="btn-submit-slot" class="bg-secondary text-primary px-6 py-2.5 rounded-button hover:bg-yellow-500 font-semibold flex items-center space-x-2 transition-colors duration-200">
                                <i class="ri-add-line"></i>
                                <span>Tambah Slot</span>
                            </button>
                        </div>
                    </form>

                    <div class="overflow-x-auto rounded-lg shadow-md border border-gray-700">
                        <table class="w-full min-w-[600px]" id="tabel-slot-jadwal">
                            <thead class="bg-gray-700/50">
                                <tr class="text-left">
                                    <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase">Jenis Jadwal</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase">Pukul</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase">Status</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                <?php if (empty($slot_jadwal_list)): ?>
                                    <tr id="no-slot-results"><td colspan="5" class="px-6 py-12 text-center text-gray-500">Tidak ada jadwal slot tersedia.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($slot_jadwal_list as $slot): ?>
                                        <tr data-id="<?= $slot['id'] ?>" data-jenis-jadwal="<?= htmlspecialchars($slot['jenis_jadwal']) ?>">
                                            <td class="px-6 py-4 text-sm text-gray-300"><?= htmlspecialchars($slot['jenis_jadwal']) ?></td>
                                            <td class="px-6 py-4 text-sm text-gray-300"><?= htmlspecialchars($slot['tanggal']) ?></td>
                                            <td class="px-6 py-4 text-sm text-gray-300"><?= htmlspecialchars($slot['pukul']) ?></td>
                                            <td class="px-6 py-4">
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                    <?= $slot['status'] == 'Dibuka' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' ?>">
                                                    <?= htmlspecialchars($slot['status']) ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="flex items-center justify-center space-x-2">
                                                    <button title="Edit" class="text-gray-300 hover:text-secondary p-1.5 btn-edit-slot"><i class="ri-pencil-line ri-lg"></i></button>
                                                    <button title="Hapus" class="text-gray-300 hover:text-red-400 p-1.5 btn-delete-slot"><i class="ri-delete-bin-line ri-lg"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div> 

    <?php 
    require __DIR__ . '/components/mobile_menu.php'; 
    require __DIR__ . '/components/footer_scripts.php'; 
    ?>
    <script src="js/pengaturanManager.js"></script>
</body>
</html>