document.getElementById("profile-image").onchange = function () {
    let form = document.getElementById('profile-image-form');
    let file = document.getElementById("profile-image").files[0];
    let imageHolder = document.getElementById('preview-image');
    let formData = new FormData();

    imageHolder.src = URL.createObjectURL(file);

    formData.append('image', file);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

    fetch(form.getAttribute('action'), {
        method: 'POST',
        body: formData
    });
};
