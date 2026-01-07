<?php
require_once 'includes/header.php';


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$vibeId = (int)$_GET['id'];


$stmt = $pdo->prepare("
    SELECT v.*, u.username 
    FROM vibes v 
    JOIN users u ON v.user_id = u.id 
    WHERE v.id = ?
");
$stmt->execute([$vibeId]);
$vibe = $stmt->fetch();


if (!$vibe) {
    header('Location: index.php');
    exit;
}
?>

<div class="detail-container">
    <div class="detail-inner">
        <div class="detail-image">
            <img src="<?php echo htmlspecialchars($vibe['image_path']); ?>" 
                 alt="<?php echo htmlspecialchars($vibe['title']); ?>">
        </div>
        
        <div class="detail-content">
            <div class="meta">
                Shared by <?php echo htmlspecialchars($vibe['username']); ?>
            </div>
            
            <h1><?php echo htmlspecialchars($vibe['title']); ?></h1>
            
            <?php if (!empty($vibe['description'])): ?>
                <div class="description">
                    <?php echo nl2br(htmlspecialchars($vibe['description'])); ?>
                </div>
            <?php endif; ?>
            
            <div class="meta">
                Posted on <?php echo date('F j, Y', strtotime($vibe['created_at'])); ?>
            </div>
            
            <div class="mt-8">
                <a href="index.php" class="btn-secondary">
                    ← Back to feed
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
