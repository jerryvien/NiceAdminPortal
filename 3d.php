<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Multi TTS Examples</title>
</head>
<body>
  <h2>Text-to-Speech Examples</h2>

  <button onclick="speakBM('Customer Service Counter, Nombor 1123, Kaunter 3')">
    📢 Customer Service Counter
  </button>
  <br><br>

  <button onclick="speakBM('Perhatian teknisyen, kerja baru sedang masuk')">
    🔧 Technician Incoming Job
  </button>

  <script>
    function speakBM(text) {
      if (!text) return;

      const utterance = new SpeechSynthesisUtterance(text);

      // Cari suara BM / fallback Indonesia
      const voices = speechSynthesis.getVoices();
      const malayVoice = voices.find(v =>
        /(ms-MY|id-ID)/i.test(v.lang)
      );
      if (malayVoice) utterance.voice = malayVoice;

      utterance.rate = 1;   // normal speed
      utterance.pitch = 1;  // normal pitch
      utterance.volume = 1; // full volume

      speechSynthesis.speak(utterance);
    }

    // Ensure voices loaded
    speechSynthesis.onvoiceschanged = () => {};
  </script>
</body>
</html>
