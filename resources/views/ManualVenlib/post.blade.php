<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Buttons/2.0.0/css/buttons.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <style>
        .hidden {
            display: none;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        .fadeInAnimation {
            animation: fadeIn 0.5s ease forwards;
        }

        .fadeOutAnimation {
            animation: fadeOut 0.5s ease forwards;
        }
    </style>
</head>

<body> @php $data->profile_pic = json_decode($data->profile_pic)[0]; @endphp <form action="{{ url('/uplodnewpost') }}" method="post" enctype="multipart/form-data"> @csrf
        <input type="hidden" name="user_id" value="{{ $data->id }}" />
        <div class="container-fluid" id="qui" style="width: 100vw; height: 100vh">
            <div class="row justify-content-end">
                <button class="btn btn-primary col-3 rounded mt-1 text-center" id="postButton" type="submit"> POST
                </button>
            </div>
            <div class="row justify-content-center">
                <div class="col-3">
                    <img src="{{ url($data->profile_pic) }}" alt="" id="profileImage"
                        class="img-fluid rounded-circle" style="width: 5rem; object-fit: cover" />
                </div>
                <div class="col-9"></div>
                <div class="col-12 mt-2">
                    <textarea name="isipost" class="col-12 form-control bg-ouline-primary" style="height: 80vh; border: none" id="post_body"
                        autofocus placeholder="Masukkan teks di sini..."></textarea>

                    <div class="col-6">
                        <img src="#" class="img-fluid card rounded m-1 hidden" id="showimg">
                    </div>
                    <div class="col-6">
                        <a href="#" id="linkfileview" class="hidden">#</a>
                    </div>


                </div>
            </div>
            <input type="file" name="filelist" class="form-control-file hidden" id="fileInput"
                accept=".doc, .docx, .pdf" />
            <input type="file" name="photo" class="form-control-file hidden" id="imageInput" accept="image/*" />
            <div class="col-12 row justify-content-end fixed-bottom p-0">
                <a class="col-4 button button-primary button-circle btn btn-lg button-longshadow hipo hidden"
                    type="button" href="#" onclick="document.getElementById('imageInput').click();"> F </a>
                <button class="col-4 button button-primary button-circle btn btn-lg button-longshadow hipo hidden"
                    type="button" href="#"
                    onclick="
                        document.getElementById('fileInput').click();
                        ">
                    E </button>
                <button class="col-4 button button-primary button-circle btn btn-lg button-longshadow"
                    onclick="toggleFileOptions()" type="button"> + </button>
            </div>
        </div>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // this if for the image preview
        document.getElementById('imageInput').addEventListener('change', function() {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('showimg').src = e.target.result;
                document.getElementById('showimg').classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        });

        // this is for the file preview
        document.getElementById('fileInput').addEventListener('change', function() {
            var file = this.files[0];
            document.getElementById('linkfileview').classList.remove('hidden');
            document.getElementById('linkfileview').href = URL.createObjectURL(file);
            document.getElementById('linkfileview').innerText = file.name;
        });
    </script>

    <script>
        function toggleFileOptions() {
            var fileOptions = document.querySelectorAll('.hipo');
            fileOptions.forEach(function(option) {
                option.classList.toggle('hidden');
                if (!option.classList.contains('hidden')) {
                    option.classList.add('fadeInAnimation');
                    option.classList.remove('fadeOutAnimation');
                } else {
                    option.classList.remove('fadeInAnimation');
                    option.classList.add('fadeOutAnimation');
                }
            });
        }
    </script>
</body>

</html>
