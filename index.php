<?php
require_once 'includes/header.php';

// Get all vibes with user information, ordered by newest first
$stmt = $pdo->query("
    SELECT v.*, u.username 
    FROM vibes v 
    JOIN users u ON v.user_id = u.id 
    ORDER BY v.created_at DESC
");
$vibes = $stmt->fetchAll();
?>

<h1 class="text-center mb-8">Latest Vibes</h1>

<?php if (empty($vibes)): ?>
    <div class="text-center">
        <p style="font-size: 1.125rem; color: rgba(255, 255, 255, 0.7);">No vibes yet. Be the first to <a href="upload.php">share a vibe</a>!</p>
    </div>
<?php else: ?>
    <div class="grid">
        <?php foreach ($vibes as $vibe): ?>
            <a href="vibe.php?id=<?php echo $vibe['id']; ?>" class="vibe-card">
                <div class="vibe-card-inner">
                    <img src="<?php echo htmlspecialchars($vibe['image_path']); ?>" 
                         alt="<?php echo htmlspecialchars($vibe['title']); ?>">
                    <div class="vibe-card-content">
                        <h3><?php echo htmlspecialchars($vibe['title']); ?></h3>
                        <p>by <?php echo htmlspecialchars($vibe['username']); ?></p>
                        <?php if (!empty($vibe['description'])): ?>
                            <p class="line-clamp-2">
                                <?php echo htmlspecialchars($vibe['description']); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
