<?php
require_once 'includes/header.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image = $_FILES['image'] ?? null;
    
   
    if (empty($title) || empty($image) || $image['error'] === UPLOAD_ERR_NO_FILE) {
        $error = 'Title and image are required.';
    } elseif (!in_array($image['type'], ['image/jpeg', 'image/png', 'image/gif'])) {
        $error = 'Only JPG, PNG, and GIF images are allowed.';
    } elseif ($image['size'] > 5 * 1024 * 1024) { 
        $error = 'Image size must be less than 5MB.';
    } else {
       
        $uploadDir = __DIR__ . '/uploads';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
       
        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $extension;
        $targetPath = $uploadDir . '/' . $filename;
        
       
        if (move_uploaded_file($image['tmp_name'], $targetPath)) {
           
            $imagePath = '/vide-vault/uploads/' . $filename;
            $stmt = $pdo->prepare("
                INSERT INTO vibes (user_id, title, description, image_path) 
                VALUES (:user_id, :title, :description, :image_path)
            ");
            
            if ($stmt->execute([
                'user_id' => $_SESSION['user_id'], 
                'title' => $title, 
                'description' => $description, 
                'image_path' => $imagePath
            ])) {
                $success = 'Vibe uploaded successfully!';
                
                $title = $description = '';
            } else {
                $error = 'Failed to save vibe. Please try again.';
                
                @unlink($targetPath);
            }
        } else {
            $error = 'Failed to upload image. Please try again.';
        }
    }
}
?>

<div class="container mt-8 p-4">
    <h1 class="text-center mb-8">Upload New Vibe</h1>

    <?php if ($error): ?>
        <div class="alert alert-error">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>


    <div class="container_chat_bot">
        <div class="container-chat-options">
            <div class="chat">
                <div class="chat-bot">
                    <textarea
                        id="title"
                        name="title"
                        placeholder="Imagine Something...✦˚"
                        required
                    ><?php echo htmlspecialchars($title ?? ''); ?></textarea>
                </div>
                <div class="options">
                    <div class="btns-add">
                        <button onclick="document.getElementById('imageInput').click()">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="20"
                                height="20"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M7 8v8a5 5 0 1 0 10 0V6.5a3.5 3.5 0 1 0-7 0V15a2 2 0 0 0 4 0V8"
                                ></path>
                            </svg>
                        </button>
                        <button>
                            <svg
                                viewBox="0 0 24 24"
                                height="20"
                                width="20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M4 5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1zm0 10a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1zm10 0a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1zm0-8h6m-3-3v6"
                                    stroke-width="2"
                                    stroke-linejoin="round"
                                    stroke-linecap="round"
                                    stroke="currentColor"
                                    fill="none"
                                ></path>
                            </svg>
                        </button>
                        <button>
                            <svg
                                viewBox="0 0 24 24"
                                height="20"
                                width="20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10m-2.29-2.333A17.9 17.9 0 0 1 8.027 13H4.062a8.01 8.01 0 0 0 5.648 6.667M10.03 13c.151 2.439.848 4.73 1.97 6.752A15.9 15.9 0 0 0 13.97 13zm9.908 0h-3.965a17.9 17.9 0 0 1-1.683 6.667A8.01 8.01 0 0 0 19.938 13M4.062 11h3.965A17.9 17.9 0 0 1 9.71 4.333A8.01 8.01 0 0 0 4.062 11m5.969 0h3.938A15.9 15.9 0 0 0 12 4.248A15.9 15.9 0 0 0 10.03 11m4.259-6.667A17.9 17.9 0 0 1 15.973 11h3.965a8.01 8.01 0 0 0-5.648-6.667"
                                    fill="currentColor"
                                ></path>
                            </svg>
                        </button>
                    </div>
                    <button type="submit" form="uploadForm" class="btn-submit">
                        <i>
                            <svg viewBox="0 0 512 512">
                                <path
                                    fill="currentColor"
                                    d="M473 39.05a24 24 0 0 0-25.5-5.46L47.47 185h-.08a24 24 0 0 0 1 45.16l.41.13l137.3 58.63a16 16 0 0 0 15.54-3.59L422 80a7.07 7.07 0 0 1 10 10L226.66 310.26a16 16 0 0 0-3.59 15.54l58.65 137.38c.06.2.12.38.19.57c3.2 9.27 11.3 15.81 21.09 16.25h1a24.63 24.63 0 0 0 23-15.46L478.39 64.62A24 24 0 0 0 473 39.05"
                                ></path>
                            </svg>
                        </i>
                    </button>
                </div>
            </div>
        </div>
        <div class="tags">
            <span onclick="setTag('Create An Image')">Create An Image</span>
            <span onclick="setTag('Analyse Data')">Analyse Data</span>
            <span onclick="setTag('More')">More</span>
        </div>
    </div>

   
    <form id="uploadForm" method="POST" action="" enctype="multipart/form-data" style="display: none;">
        <input type="file" id="imageInput" name="image" accept="image/*" required onchange="handleImageSelect(this)">
        <input type="text" id="description" name="description" value="">
    </form>

    
    <div id="imagePreview" class="mt-8 text-center" style="display: none;">
        <img id="previewImg" src="" alt="Preview" class="image-preview">
        <p style="color: rgba(255, 255, 255, 0.7); margin-top: 1rem; font-size: 0.875rem;">Image selected: <span id="fileName"></span></p>
    </div>
</div>

<script>
function setTag(tag) {
    const textarea = document.getElementById('title');
    const currentText = textarea.value;
    if (currentText && !currentText.endsWith(' ')) {
        textarea.value = currentText + ' ' + tag;
    } else {
        textarea.value = currentText + tag;
    }
}

function handleImageSelect(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('fileName').textContent = file.name;
            document.getElementById('imagePreview').style.display = 'block';
        };
        
        reader.readAsDataURL(file);
    }
}


document.getElementById('uploadForm').addEventListener('submit', function(e) {
 
    const title = document.getElementById('title').value;
    document.getElementById('description').value = title;
    
   
    const imageInput = document.getElementById('imageInput');
    if (!imageInput.files || imageInput.files.length === 0) {
        e.preventDefault();
        alert('Please select an image to upload.');
        return false;
    }
    
   
    if (!title.trim()) {
        e.preventDefault();
        alert('Please enter a title for your vibe.');
        return false;
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>
