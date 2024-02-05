<div>
    <!-- Knowing is not enough; we must apply. Being willing is not enough; we must do. - Leonardo da Vinci -->
    <script src="https://cdn.tiny.cloud/1/cbc5zq3rhm55pve0caxhjootkaym3aflt6zbwuq1halrhbky/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
     tinymce.init({
            selector: 'textarea#myeditorinstance', // Gantilah ini dengan selektor CSS yang sesuai dengan elemen placeholder untuk TinyMCE
            plugins: [
                'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
                'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
                'media', 'table', 'emoticons', 'template', 'help', 'image media link tinydrive code imagetools uploadimage' // Tambahkan plugin uploadimage di sini
            ],
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table | media | insertfile image link | code | uploadimage', // Tambahkan uploadimage ke toolbar
            tinydrive_token_provider: 'URL_TO_YOUR_TOKEN_PROVIDER',
            tinydrive_dropbox_app_key: 'YOUR_DROPBOX_APP_KEY',
            tinydrive_google_drive_key: 'YOUR_GOOGLE_DRIVE_KEY',
            tinydrive_google_drive_client_id: 'YOUR_GOOGLE_DRIVE_CLIENT_ID',
            images_upload_handler: function (blobInfo, success, failure) {
                // Atur logika unggah berkas di sini, contohnya menggunakan XMLHttpRequest atau Fetch API
                // Pastikan untuk memanggil success() dengan URL berkas setelah berhasil diunggah
            }
        });
    </script>
</div>
