const chatBody = document.querySelector(".chat-body");
const messageInput = document.querySelector(".message-input");
const updateReadAloudIcon = (speaking) => {
  const btn = document.querySelector("#read-aloud-btn");
  if (!btn) return;
  const icon = btn.querySelector("i");
  if (speaking) {
    icon.classList.remove("fa-volume-up");
    icon.classList.add("fa-volume-mute");
    btn.title = "Stop Reading";
  } else {
    icon.classList.remove("fa-volume-mute");
    icon.classList.add("fa-volume-up");
    btn.title = "Read Aloud";
  }
};
const sendMessage = document.querySelector("#send-message");

const fileInput = document.querySelector("#file-input");
const fileUploadWrapper = document.querySelector(".file-upload-wrapper");
const fileCancelButton = fileUploadWrapper.querySelector("#file-cancel");
const chatbotToggler = document.querySelector("#chatbot-toggler");
const closeChatbot = document.querySelector("#close-chatbot");
const themeButton = document.querySelector("#dark_switch");

// 🧠 Gemini API setup
const API_KEY = "AIzaSyAirC1RKFgqW53NiRXGcwIi5vPNJp1jBds";
const API_URL = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${API_KEY}`;
// Initialize user data and chat history
const userData = {
  message: null,
  file: {
    data: null,
    mime_type: null,
  },
};

const chatHistory = [];
const initialInputHeight = messageInput.scrollHeight;

// Create message element
const createMessageElement = (content, ...classes) => {
  const div = document.createElement("div");
  div.classList.add("message", ...classes);
  div.innerHTML = content;
  return div;
};
let isSpeaking = false;
let currentUtterance = null;

const speak = (text) => {
  if (!("speechSynthesis" in window)) {
    console.warn("Speech synthesis not supported in this browser.");
    return;
  }

  if (isSpeaking && window.speechSynthesis.speaking) {
    // 🔄 PAUSE speech
    window.speechSynthesis.pause();
    isSpeaking = false;
    updateReadAloudIcon(false);
    return;
  }

  if (!isSpeaking && window.speechSynthesis.paused) {
    // ▶️ RESUME speech
    window.speechSynthesis.resume();
    isSpeaking = true;
    updateReadAloudIcon(true);
    return;
  }

  // 🆕 First time speak
  window.speechSynthesis.cancel();
  currentUtterance = new SpeechSynthesisUtterance(text);
  currentUtterance.lang = "en-PH";
  currentUtterance.rate = 1;
  currentUtterance.pitch = 1;

  currentUtterance.onstart = () => {
    isSpeaking = true;
    updateReadAloudIcon(true);
  };

  currentUtterance.onend = () => {
    isSpeaking = false;
    updateReadAloudIcon(false);
  };

  window.speechSynthesis.speak(currentUtterance);
};

// 🤖 Generate bot response
const generateBotResponse = async (incomingMessageDiv) => {
  const messageElement = incomingMessageDiv.querySelector(".message-text");

  // Add user message to history
  chatHistory.push({
    role: "user",
    parts: [
      { text: userData.message },
      ...(userData.file?.data ? [{ inline_data: userData.file }] : []),
    ],
  });

  const requestOptions = {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ contents: chatHistory }),
  };

  try {
    const response = await fetch(API_URL, requestOptions);
    const data = await response.json();
    if (!response.ok) throw new Error(data.error.message);

    const apiResponseText =
      data.candidates?.[0]?.content?.parts?.[0]?.text || "No response received.";

    messageElement.innerText = apiResponseText.trim();

    // 🔊 Speak bot reply aloud
    speak(apiResponseText);

    // Save to chat history
    chatHistory.push({
      role: "model",
      parts: [{ text: apiResponseText }],
    });
  } catch (error) {
    messageElement.innerText = "Error: " + error.message;
    messageElement.style.color = "#ff0000";
  } finally {
    userData.file = {};
    incomingMessageDiv.classList.remove("thinking");
    chatBody.scrollTo({ top: chatBody.scrollHeight, behavior: "smooth" });
  }
};

// ✉️ Handle user sending message
const handleOutgoingMessage = (e) => {
  e.preventDefault();
  userData.message = messageInput.value.trim();
  if (!userData.message) return;

  messageInput.value = "";
  messageInput.dispatchEvent(new Event("input"));
  fileUploadWrapper.classList.remove("file-uploaded");

  const messageContent = `<div class="message-text"></div>
    ${userData.file?.data ? `<img src="data:${userData.file.mime_type};base64,${userData.file.data}" class="attachment" />` : ""}`;

  const outgoingMessageDiv = createMessageElement(messageContent, "user-message");
  outgoingMessageDiv.querySelector(".message-text").innerText = userData.message;
  chatBody.appendChild(outgoingMessageDiv);
  chatBody.scrollTo({ top: chatBody.scrollHeight, behavior: "smooth" });

  // Bot thinking indicator
  setTimeout(() => {
    const botMessage = `
     <svg class="bot-avatar" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 1024 1024">
          <path
            d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5zM867.2 644.5V453.1h26.5c19.4 0 35.1 15.7 35.1 35.1v121.1c0 19.4-15.7 35.1-35.1 35.1h-26.5zM95.2 609.4V488.2c0-19.4 15.7-35.1 35.1-35.1h26.5v191.3h-26.5c-19.4 0-35.1-15.7-35.1-35.1zM561.5 149.6c0 23.4-15.6 43.3-36.9 49.7v44.9h-30v-44.9c-21.4-6.5-36.9-26.3-36.9-49.7 0-28.6 23.3-51.9 51.9-51.9s51.9 23.3 51.9 51.9z" />
        </svg>
      <div class="message-text">
        <div class="thinking-indicator">
          <div class="dot"></div><div class="dot"></div><div class="dot"></div>
        </div>
      </div>
    `;
    const incomingMessageDiv = createMessageElement(botMessage, "bot-message", "thinking");
    chatBody.appendChild(incomingMessageDiv);
    chatBody.scrollTo({ top: chatBody.scrollHeight, behavior: "smooth" });
    generateBotResponse(incomingMessageDiv);
  }, 600);
};

// 📝 Auto-expand input field
messageInput.addEventListener("input", () => {
  messageInput.style.height = `${initialInputHeight}px`;
  messageInput.style.height = `${messageInput.scrollHeight}px`;
  document.querySelector(".chat-form").style.borderRadius =
    messageInput.scrollHeight > initialInputHeight ? "15px" : "32px";
});

// Enter key to send (desktop only)
messageInput.addEventListener("keydown", (e) => {
  const userMessage = e.target.value.trim();
  if (e.key === "Enter" && !e.shiftKey && userMessage && window.innerWidth > 768) {
    handleOutgoingMessage(e);
  }
});

// 📎 File upload
fileInput.addEventListener("change", () => {
  const file = fileInput.files[0];
  if (!file) return;

  const reader = new FileReader();
  reader.onload = (e) => {
    fileInput.value = "";
    fileUploadWrapper.querySelector("img").src = e.target.result;
    fileUploadWrapper.classList.add("file-uploaded");
    const base64String = e.target.result.split(",")[1];
    userData.file = {
      data: base64String,
      mime_type: file.type,
    };
  };
  reader.readAsDataURL(file);
});

fileCancelButton.addEventListener("click", () => {
  userData.file = {};
  fileUploadWrapper.classList.remove("file-uploaded");
});

// 😀 Emoji picker setup
const picker = new EmojiMart.Picker({
  theme: "light",
  skinTonePosition: "none",
  previewPosition: "none",
  onEmojiSelect: (emoji) => {
    const { selectionStart: start, selectionEnd: end } = messageInput;
    messageInput.setRangeText(emoji.native, start, end, "end");
    messageInput.focus();
  },
  onClickOutside: (e) => {
    if (e.target.id === "emoji-picker") {
      document.body.classList.toggle("show-emoji-picker");
    } else {
      document.body.classList.remove("show-emoji-picker");
    }
  },
});

// 🌙 Theme toggle
const loadDataFromLocalstorage = () => {
  const themeColor = localStorage.getItem("themeColor");
  const isLightMode = themeColor === "light_mode";
  document.body.classList.toggle("light-mode", isLightMode);
  themeButton.classList.toggle("fa-moon", isLightMode);
  themeButton.classList.toggle("fa-sun", !isLightMode);
};

themeButton.addEventListener("click", () => {
  const isLightMode = document.body.classList.toggle("light-mode");
  localStorage.setItem("themeColor", isLightMode ? "light_mode" : "dark_mode");
  themeButton.classList.toggle("fa-moon", isLightMode);
  themeButton.classList.toggle("fa-sun", !isLightMode);
});

loadDataFromLocalstorage();

// 🎛️ Event listeners
document.querySelector(".chat-form").appendChild(picker);
sendMessage.addEventListener("click", (e) => handleOutgoingMessage(e));
document.querySelector("#file-upload").addEventListener("click", () => fileInput.click());
closeChatbot.addEventListener("click", () => document.body.classList.remove("show-chatbot"));
chatbotToggler.addEventListener("click", () => document.body.classList.toggle("show-chatbot"));


document.querySelector("#read-aloud-btn").addEventListener("click", () => {
  const lastBotMessage = document.querySelector(".bot-message:last-child .message-text");
  if (lastBotMessage) speak(lastBotMessage.innerText);
});
