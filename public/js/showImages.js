document.addEventListener('DOMContentLoaded', function () {
    const photoMainInput = document.getElementById('photo_main');
    const photosInput = document.getElementById('photos');
    const photoMainPreview = document.getElementById('photo_main_preview');
    const photosPreview = document.getElementById('photos_preview');

    photoMainInput.addEventListener('change', function () {
        displayImage(this.files[0], photoMainPreview);
    });

    photosInput.addEventListener('change', function () {
        displayImages(this.files, photosPreview);
    });

    function displayImage(file, container) {
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                container.innerHTML = `<img src="${e.target.result}" class="img-fluid" alt="Foto principal">`;
            };
            reader.readAsDataURL(file);
        }
    }

    function displayImages(files, container) {
        container.innerHTML = '';
        for (let i = 0; i < files.length; i++) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-fluid', 'm-2');
                img.style.maxWidth = '100px';
                container.appendChild(img);
            };
            reader.readAsDataURL(files[i]);
        }
    }
});
