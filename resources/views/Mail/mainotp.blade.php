<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OTP EMAIL</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap"
      rel="stylesheet"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body
    style="
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #ffffff;
      font-size: 14px;
    ">
    <div
    style="
      max-width: 680px;
      margin: 0 auto;
      padding: 45px 30px 60px;
      background: #f4f7ff;
      background-image: url(https://uploads-ssl.webflow.com/65f9c93356646c3ad53f521c/65f9c95d42f9cdaccad262ab_coverPolos.png);
      background-repeat: no-repeat;
      background-size: 800px 452px;
      background-position: top center;
      font-size: 14px;
      color: #434343;
    "
  >
    <header>
      <table style="width: 100%;">
        <tbody>
          <tr style="height: 0;">
            <td>
              <img
                alt=""
                src="https://uploads-ssl.webflow.com/65f9c93356646c3ad53f521c/65f9c967a87745a53736cbd4_logo_white.png"
                height="30px"
              />
            </td>
            <td style="text-align: right;">
              <span
                style="font-size: 16px; line-height: 30px; color: #ffffff;"
                id="date"</span
              >
            </td>
          </tr>
        </tbody>
      </table>
    </header>

    <main>
      <div
        style="
          margin: 0;
          margin-top: 70px;
          padding: 92px 30px 115px;
          background: #ffffff;
          border-radius: 30px;
          text-align: center;
        "
      >
        <div style="width: 100%; max-width: 489px; margin: 0 auto;">
          <h1
            style="
              margin: 0;
              font-size: 24px;
              font-weight: 500;
              color: #1f1f1f;
            "
          >
            Your OTP
          </h1>
          <p
            style="
              margin: 0;
              margin-top: 17px;
              font-size: 16px;
              font-weight: 500;
            "
          >
            Dear Heeroes,
          </p>
          <p
            style="
              margin: 0;
              margin-top: 17px;
              font-weight: 500;
              letter-spacing: 0.56px;
            "
          >
          Thank you for choosing Heeroes, your trusted safety zone. This email contains your One-Time Password (OTP) for logging in to your Heeroes account.
          One-Time Password (OTP):
          </p>
          <p
            style="
              margin: 0;
              margin-top: 60px;
              font-size: 40px;
              font-weight: 600;
              letter-spacing: 25px;
              color: #ba3d4f;
            "
          >
            {{ $otp }}
          </p>
          <p
            style="
              margin: 0;
              margin-top: 17px;
              font-weight: 500;
              letter-spacing: 0.56px;
            "
          >
          Please don't share this code with anyone for your safety.
          </p>
        </div>
      </div>

      <p
        style="
          max-width: 400px;
          margin: 0 auto;
          margin-top: 90px;
          text-align: center;
          font-weight: 500;
          color: #8c8c8c;
        "
      >
      If you didn't request a login code, please contact Heeru Support immediately.
      </p>
    </main>

    <footer
      style="
        width: 100%;
        max-width: 490px;
        margin: 20px auto 0;
        text-align: center;
        border-top: 1px solid #e6ebf1;
      "
    >
      <p
        style="
          margin: 0;
          margin-top: 40px;
          font-size: 16px;
          font-weight: 600;
          color: #434343;
        "
      >
        Heeru - We Heer U
      </p>
      <p style="margin: 0; margin-top: 16px; color: #434343;">
        Copyright © 2024 Heeru. All rights reserved.
      </p>
    </footer>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const currentDate = new Date();
    const months = [
      "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
    ];
    const formattedDate = `${currentDate.getDate()} ${months[currentDate.getMonth()]}, ${currentDate.getFullYear()}`;
    document.getElementById("date").innerText = formattedDate;
  </script>
</html>
