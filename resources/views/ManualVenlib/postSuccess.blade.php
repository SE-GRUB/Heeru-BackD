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

<body>
    <h1>Berhasil di Upload</h1>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
