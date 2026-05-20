<style>
    .modal-overlay {
        position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
        background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);
        z-index: 10000; display: none; justify-content: center; align-items: center;
        opacity: 0; transition: opacity 0.3s ease;
    }
    .modal-overlay.active { display: flex; opacity: 1; }
    
    .modal-content {
        background: #f0ebe2; border-radius: 16px; padding: 2rem; width: 90%; max-width: 450px;
        position: relative; transform: translateY(20px); transition: transform 0.3s ease;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }
    .modal-overlay.active .modal-content { transform: translateY(0); }
    
    .modal-close {
        position: absolute; top: 1rem; right: 1rem; cursor: pointer;
        background: none; border: none; font-size: 1.5rem; color: #1c1c1e; line-height: 1;
    }
    
    .modal-header { font-size: 1.5rem; font-weight: 700; color: #1c1c1e; margin-bottom: 1.5rem; font-family: 'Syne', sans-serif; }
    
    .profile-avatar-preview {
        width: 80px; height: 80px; border-radius: 50%; background: #c94f2c; color: #fff;
        display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 700;
        margin-bottom: 1rem; object-fit: cover;
    }
</style>

<!-- Cropper.js -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<div class="modal-overlay" id="profileModal">
    <div class="modal-content">
        <button class="modal-close" onclick="closeProfileModal()">&times;</button>
        <div class="modal-header">Edit Profile</div>
        
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileUpdateForm">
            @csrf
            <div style="display: flex; flex-direction: column; align-items: center; margin-bottom: 1.5rem;">
                
                <div id="previewContainer">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('profile-images/'.Auth::user()->avatar) }}" class="profile-avatar-preview" id="avatarPreview">
                    @else
                        <div class="profile-avatar-preview" id="avatarPreviewInit">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <img src="" class="profile-avatar-preview" id="avatarPreview" style="display:none;">
                    @endif
                </div>

                <div id="cropContainer" style="display:none; width:100%; max-height: 300px; margin-bottom: 1rem;">
                    <img id="imageToCrop" style="max-width: 100%; display:block;">
                </div>
                
                <div id="cropActions" style="display:none; gap: 10px; margin-bottom: 1rem;">
                    <button type="button" class="action-btn" style="background:#e0e0e0; color:#333; padding: 0.5rem 1rem;" onclick="cancelCrop()">Cancel</button>
                    <button type="button" class="action-btn primary" style="padding: 0.5rem 1rem;" onclick="applyCrop()">Apply Crop</button>
                </div>
                
                <label for="avatarInput" id="changePhotoLabel" style="cursor: pointer; color: #c94f2c; font-size: 0.9rem; font-weight: 600;">Change Photo</label>
                <input type="file" id="avatarInput" name="avatar" style="display: none;" accept="image/*" onchange="initCrop(event)">
            </div>
            
            <div style="margin-bottom: 1rem;">
                <label style="display:block; margin-bottom:0.5rem; font-size:0.9rem; font-weight:600;">Name</label>
                <input type="text" name="name" value="{{ Auth::user()->name }}" required style="width:100%; padding:0.8rem; border:1px solid #ccc; border-radius:8px; font-family:'Epilogue', sans-serif;">
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-size:0.9rem; font-weight:600;">Email</label>
                <input type="email" name="email" value="{{ Auth::user()->email }}" required style="width:100%; padding:0.8rem; border:1px solid #ccc; border-radius:8px; font-family:'Epilogue', sans-serif;">
            </div>
            
            <button type="submit" class="action-btn primary" style="width:100%; justify-content:center; padding:0.8rem;" id="saveProfileBtn">Save Changes</button>
        </form>
    </div>
</div>

<script>
    let cropper = null;

    function openProfileModal() {
        document.getElementById('profileModal').classList.add('active');
    }
    
    function closeProfileModal() {
        document.getElementById('profileModal').classList.remove('active');
        cancelCrop(); // reset on close
    }
    
    function initCrop(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewContainer').style.display = 'none';
            document.getElementById('changePhotoLabel').style.display = 'none';
            document.getElementById('saveProfileBtn').style.display = 'none';
            
            const cropContainer = document.getElementById('cropContainer');
            const imageToCrop = document.getElementById('imageToCrop');
            const cropActions = document.getElementById('cropActions');
            
            cropContainer.style.display = 'block';
            cropActions.style.display = 'flex';
            imageToCrop.src = e.target.result;

            if (cropper) {
                cropper.destroy();
            }

            cropper = new Cropper(imageToCrop, {
                aspectRatio: 1,
                viewMode: 1,
                autoCropArea: 1,
                responsive: true,
                background: false
            });
        }
        reader.readAsDataURL(file);
    }

    function applyCrop() {
        if (!cropper) return;

        cropper.getCroppedCanvas({
            width: 400,
            height: 400
        }).toBlob((blob) => {
            // Update the file input with the new cropped image
            const fileInput = document.getElementById('avatarInput');
            const dt = new DataTransfer();
            const newFile = new File([blob], 'avatar.jpg', { type: 'image/jpeg' });
            dt.items.add(newFile);
            fileInput.files = dt.files;

            // Update preview
            const preview = document.getElementById('avatarPreview');
            preview.src = URL.createObjectURL(blob);
            preview.style.display = 'block';
            
            const init = document.getElementById('avatarPreviewInit');
            if(init) init.style.display = 'none';

            cancelCrop(true);
        }, 'image/jpeg', 0.9);
    }

    function cancelCrop(applied = false) {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        document.getElementById('cropContainer').style.display = 'none';
        document.getElementById('cropActions').style.display = 'none';
        document.getElementById('previewContainer').style.display = 'block';
        document.getElementById('changePhotoLabel').style.display = 'block';
        document.getElementById('saveProfileBtn').style.display = 'flex';

        if (!applied) {
            // Reset input so they can select the same file again if they cancelled
            document.getElementById('avatarInput').value = '';
        }
    }
    
    // Close modal when clicking outside
    document.getElementById('profileModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeProfileModal();
        }
    });
</script>
