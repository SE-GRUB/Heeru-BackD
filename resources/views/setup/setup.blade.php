<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Setup</title>

    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&family=Rozha+One&display=swap"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="setup.css" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
  </head>

  <body>
    <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Setup</title>

    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&family=Rozha+One&display=swap"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="setup.css" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
  </head>

  <body>
    <div class="circle"></div>
    <div class="container-fluid">
      <h2>
        Hello,
        <span id="databaseName" class="databaseName">isi</span>
      </h2>
      <p>Let us know you more</p>

      <!-- <div class="photoprofile mb-">
        <div class="lingkarannya">
            <input type="file" id="fileInput" accept="image/*" style="display: none;" />
            <label for="fileInput" class="edit-icon" id="labelForFileInput">
                <img src="./asset/editpp.png" alt="Edit Profile" />
            </label>
        </div>
      </div>    -->

      <form action="{{ route('user.edit') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="photoprofile mb-">
            <div class="lingkarannya" id="profileImageContainer">
                <label for="fileInput" class="edit-icon" id="labelForFileInput">
                    <img id="pensil" src="./asset/editpp.png" alt="" />
                    <img style="display: none;" id="profileImage" src="" alt="" />
                    <input type="file" name="profile_picture" id="fileInput" accept="image/*" style="display: none;" />
                </label>
            </div>
            <button type="submit">Update Profile Picture</button>
        </div>
    </form>

      <div class="formnya">
        <div class="mb-3">
          <input
            type="email"
            class="form-control"
            id="emailinput"
            placeholder="Email"
          />
          <span id="errortext" class="text-danger hide">text</span>
        </div>

        <div class="mb-3">
          <input
            type="password"
            class="form-control"
            id="passwordinput"
            placeholder="Password"
          />
          <span id="errortext2" class="text-danger hide">text</span>
        </div>

        <div class="mb-3">
          <input
            type="password"
            class="form-control"
            id="passwordconfirmationinput"
            placeholder="Password Confirmation"
          />
          <span id="errortext3" class="text-danger hide">text</span>
        </div>

        <div class="d-grid gap-2 col-6 mx-auto">
          <button class="btn btn-primary" type="button" id="submitBtn">
            Submit
          </button>
        </div>

        <div class="needhelp">
          <a href="#">Need help?</a>
        </div>
      </div>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
    <script src="main.js"></script>
    <script>
      initpoin3();
    </script>
  </body>
</html>


      <div class="formnya">
        <div class="mb-3">
          <input
            type="email"
            class="form-control"
            id="emailinput"
            placeholder="Email"
          />
          <span id="errortext" class="text-danger hide">text</span>
        </div>

        <div class="mb-3">
          <input
            type="password"
            class="form-control"
            id="passwordinput"
            placeholder="Password"
          />
          <span id="errortext2" class="text-danger hide">text</span>
        </div>

        <div class="mb-3">
          <input
            type="password"
            class="form-control"
            id="passwordconfirmationinput"
            placeholder="Password Confirmation"
          />
          <span id="errortext3" class="text-danger hide">text</span>
        </div>

        <div class="d-grid gap-2 col-6 mx-auto">
          <button class="btn btn-primary" type="button" id="submitBtn">
            Submit
          </button>
        </div>

        <div class="needhelp">
          <a href="#">Need help?</a>
        </div>
      </div>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
    <script src="main.js"></script>
    <script>
      initpoin3();
    </script>
  </body>
</html>