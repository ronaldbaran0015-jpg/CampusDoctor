
const menuBtn = document.getElementById('menuBtn');
const menu = document.getElementById('menu');
const textarea = document.querySelector('.message-input');
const leftControls = document.getElementById('left-controls');
const toggleIcons = document.getElementById('toggle-icons');
const micButton = document.querySelector('button[type="button"] i.fa-microphone').parentNode; // Get the mic button

menuBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    menu.classList.toggle('show');
});

// Hide menu when clicking outside
document.addEventListener('click', () => {
    menu.classList.remove('show');
});

textarea.addEventListener('input', () => {
    textarea.style.height = 'auto';
    const newHeight = Math.min(textarea.scrollHeight, 100);
    textarea.style.height = newHeight + 'px';
    textarea.style.overflowY = newHeight >= 100 ? 'auto' : 'hidden';

    if (newHeight > 45) {
        leftControls.style.display = 'none';
        toggleIcons.style.display = 'flex';
    } else {
        leftControls.style.display = 'flex';
        toggleIcons.style.display = 'none';
    }
});

toggleIcons.addEventListener('click', () => {
    leftControls.style.display = 'flex';
    toggleIcons.style.display = 'none';
    textarea.style.height = '45px';
    textarea.style.overflowY = 'hidden';
});

// ================================
// 🎤 SPEECH RECOGNITION HANDLER
// ================================




// Validate elements
if (!textarea || !micButton) {
    console.error('Required elements not found');
    alert('Error: Required elements not found');
} else {
    let recognition;
    let isListening = false;

    try {
        // Check compatibility
        window.SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        recognition = new window.SpeechRecognition();
    } catch (error) {
        console.error('Error creating speech recognition object:', error);
        alert('Speech recognition not supported in this browser.');
    }

    if (recognition) {
        recognition.lang = 'en-US';
        recognition.interimResults = false;
        recognition.maxAlternatives = 1;

        // 🔘 Mic button toggle
        micButton.addEventListener('click', () => {
            try {
                if (!isListening) {
                    recognition.start();
                } else {
                    recognition.stop();
                }
            } catch (error) {
                console.error('Error starting speech recognition:', error);
                alert('Error starting speech recognition. Please try again.');
            }
        });

        // 🟢 Start listening
        recognition.onstart = () => {
            isListening = true;
            micButton.querySelector('i').style.color = '#ff3b3b'; // red mic
            micButton.querySelector('small').textContent = 'Listening...';
            console.log('🎤 Listening...');
        };

        // 🟡 Capture voice result
        recognition.onresult = (event) => {
            try {
                const transcript = event.results[0][0].transcript.trim();
                textarea.value += transcript + ' ';
                textarea.dispatchEvent(new Event('input')); // trigger input event
                console.log('You said:', transcript);
            } catch (error) {
                console.error('Error processing speech recognition result:', error);
                alert('Error processing speech recognition result.');
            }
        };

        // 🔴 Stop listening
        recognition.onend = () => {
            isListening = false;
            micButton.querySelector('i').style.color = '';
            micButton.querySelector('small').textContent = 'Speech';
            console.log('🛑 Stopped listening');
        };

        recognition.onerror = (event) => {
            console.error('Speech recognition error:', event.error);
            alert('Speech recognition error: ' + event.error);
            isListening = false;
            micButton.querySelector('i').style.color = '';
            micButton.querySelector('small').textContent = 'Speech';
        };
    }
}