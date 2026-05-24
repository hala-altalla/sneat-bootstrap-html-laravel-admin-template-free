<!DOCTYPE html>
<html>

<head>
  <title>Starting Chat...</title>
</head>

<body>

  <h3>Loading chat...</h3>

  <script>
  // 📌 قراءة التوكن من الرابط
  const params = new URLSearchParams(window.location.search);

  const token = params.get('token');
  const conversation = params.get('conversation');

  // 🚨 تحقق بسيط
  if (!token || !conversation) {
    alert("Missing token or conversation!");
  } else {

    // 💾 تخزين التوكن بالمتصفح
    localStorage.setItem('access_token', token);

    // 🚀 تحويل للشات
    window.location.href = "/chat/" + conversation;
  }
  </script>


</body>

</html>
