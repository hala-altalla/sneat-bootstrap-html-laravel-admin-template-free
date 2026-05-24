<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Chat</title>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> @vite(['resources/js/app.js'])

  <style>
  body {
    margin: 0;
    font-family: 'Arial';
    background: linear-gradient(135deg, #eef2f3, #d9e4f5);
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .chat-box {
    width: 420px;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border-radius: 18px;
    padding: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    display: flex;
    flex-direction: column;
  }

  h3 {
    text-align: center;
    margin: 5px 0 15px;
    color: #333;
    font-weight: bold;
  }

  #messages {
    height: 420px;
    overflow-y: auto;
    padding: 10px;
    background: #fafafa;
    border-radius: 12px;
    box-shadow: inset 0 0 8px rgba(0, 0, 0, 0.05);
  }

  .msg {
    padding: 10px 14px;
    margin: 8px 0;
    border-radius: 14px;
    max-width: 75%;
    word-wrap: break-word;
    animation: fadeIn 0.25s ease-in-out;
    font-size: 14px;
    line-height: 1.4;
  }

  .me,
  .other {
    background: #ffffff;
    border: 1px solid #eee;
    margin-left: auto;
    margin-right: auto;
    text-align: left;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
  }

  .send-box {
    display: flex;
    margin-top: 12px;
    gap: 8px;
  }

  input {
    flex: 1;
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #ddd;
    outline: none;
  }

  input:focus {
    border-color: #7aa7ff;
    box-shadow: 0 0 5px rgba(122, 167, 255, 0.5);
  }

  button {
    padding: 10px 15px;
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    color: white;
    cursor: pointer;
    transition: 0.2s;
  }

  button:hover {
    transform: scale(1.05);
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(5px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }




  /* dark mode */
  .dark {
    background: #111;
  }

  .dark .chat-box {
    background: #222;
    color: blue;
  }

  .dark #messages {
    background: #333;
  }

  .dark {
    color: black;
  }

  /* typing */
  #typing {
    font-size: 12px;
    color: gray;
    padding: 5px;
  }
  </style>
</head>

<body>
  <div class="chat-box">
    <h3 style="color: #6a11cb;">💬 Chat Room</h3>
    <button onclick="toggleDark()">🌙</button>

    <div id="messages"></div>

    <div class="send-box">
      <input type="text" id="msg">
      <button onclick="send()">Send</button>
    </div>

  </div>
  <script>
  const conversationId = "{{ $conversation }}";
  const senderId = "{{ $senderId }}";

  const token = localStorage.getItem("access_token");
  axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;

  axios.get(`/api/messages/${conversationId}`)
    .then(res => {
      res.data.forEach(addMessage);
    });

  function addMessage(msg) {
    let div = document.createElement("div");

    div.className = (msg.sender_user_id == senderId) ? "msg me" : "msg other";

    div.innerText = msg.message;

    document.getElementById("messages").appendChild(div);
  }

  function send() {
    let input = document.getElementById("msg");

    if (!input.value.trim()) return;

    axios.post('/api/messages', {
      conversation_id: conversationId,
      sender_user_id: senderId,
      message: input.value
    });

    input.value = "";
  }

  document.addEventListener("DOMContentLoaded", () => {

    const channel = `chat.${conversationId}`;

    window.Echo.private(channel)
      .listen('.message.sent', (e) => {

        addMessage(e.message?.message ? e.message : e);
      });

  });

  // auto scroll
  function scrollToBottom() {
    let box = document.getElementById("messages");
    box.scrollTop = box.scrollHeight;
  }
  // dark mode
  function toggleDark() {
    document.body.classList.toggle("dark");
  }




  // typing indicator (frontend only)
  let typingTimeout;

  document.getElementById("msg").addEventListener("input", () => {
    document.getElementById("typing").innerText = "typing...";

    clearTimeout(typingTimeout);

    typingTimeout = setTimeout(() => {
      document.getElementById("typing").innerText = "";
    }, 1000);
  });
  </script>
</body>



</html>