<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suggestions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Barlow', sans-serif;
        }
        .chat-container {
            background-color: #f8fafc;
            color: #374151;
            padding: 20px;
            border-radius: 10px;
            max-width: 800px;
            margin: auto;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .message-container {
            margin-top: 20px;
            overflow-y: auto;
            max-height: 500px;
        }
        .message {
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
            font-size: 16px;
            line-height: 1.5;
        }
        .message.user {
            align-self: flex-end;
            background-color: #bfdbfe;
        }
        .message.bot {
            align-self: flex-start;
            background-color: #e5e7eb;
        }
        .input-container {
            display: flex;
            margin-top: 20px;
        }
        .input-container input {
            flex: 1;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            outline: none;
        }
        .input-container button {
            background-color: #2563eb;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            margin-left: 10px;
            cursor: pointer;
        }
        .input-container button:hover {
            background-color: #1d4ed8;
        }
        .typing-indicator {
            display: none;
            font-style: italic;
            color: #9ca3af;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body class="bg-blue-100 text-gray-800">
    <?php include_once '../includes/sidebar.php'; ?>
    <div class="ml-64 p-8">
        <h1 class="text-3xl font-bold mb-6">Suggestions</h1>
        <div class="chat-container">
            <h2 class="text-xl font-semibold mb-4">Chat with Your AI Nutritionist</h2>
            
            <div id="message-container" class="message-container">
                <!-- Messages will be dynamically added here -->
            </div>
            
            <p id="typing-indicator" class="typing-indicator">AI is typing...</p>

            <div class="input-container">
                <input id="user-input" type="text" placeholder="Ask about your diet..." />
                <button onclick="sendMessage()">Send</button>
            </div>
        </div>
    </div>

    <script>
    const messageContainer = document.getElementById('message-container');
    const typingIndicator = document.getElementById('typing-indicator');

    async function sendMessage() {
        const userInput = document.getElementById('user-input').value;

        if (!userInput.trim()) return;

        // Display user message
        addMessage(userInput, 'user');

        // Show typing indicator
        typingIndicator.style.display = 'block';

        try {
            // Fetch response from PHP script via Ajax
            const response = await fetch('../controller/fetch_ai.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ prompt: userInput }),
            });

            const reader = response.body.getReader();
            const decoder = new TextDecoder();
            let botMessage = '';
            let messageElement = addMessage('', 'bot');

            // Typing animation: Read and display character-by-character
            while (true) {
                const { done, value } = await reader.read();
                if (done) break;

                botMessage += decoder.decode(value);

                // Update the displayed text character by character
                await displayTypingEffect(messageElement, botMessage);
            }

            typingIndicator.style.display = 'none'; // Hide typing indicator
        } catch (error) {
            typingIndicator.style.display = 'none';
            addMessage('Error fetching recommendation. Please try again.', 'bot');
        }

        // Clear input field
        document.getElementById('user-input').value = '';
    }

    // Add a message to the chat container
    function addMessage(content, type) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${type}`;
        messageDiv.textContent = content;
        messageContainer.appendChild(messageDiv);
        messageContainer.scrollTop = messageContainer.scrollHeight; // Scroll to the latest message
        return messageDiv;
    }

    // Display text character-by-character with smooth typing effect
    async function displayTypingEffect(element, text) {
        const delay = 25; // Delay in milliseconds for each character
        for (let i = element.textContent.length; i < text.length; i++) {
            element.textContent += text[i];
            messageContainer.scrollTop = messageContainer.scrollHeight; // Keep scrolling with new text
            await new Promise(resolve => setTimeout(resolve, delay));
        }
    }
</script>

</body>
</html>
