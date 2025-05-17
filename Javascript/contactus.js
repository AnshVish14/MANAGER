document.getElementById('contactForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    // Get form values
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const message = document.getElementById('message').value;
    
    // Display response message
    document.getElementById('responseMessage').textContent = `Thank you, ${name}. We have received your message.`;
    
    // Optionally clear the form
    document.getElementById('contactForm').reset();
});
