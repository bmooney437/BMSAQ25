document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    const errorDiv = document.getElementById('error');
    
    // Clear previous error message
    errorDiv.textContent = "";
    
    // Send login data to the PHP API
    fetch('login.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ email, password })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        // On success, redirect to welcome page
        window.location.href = 'welcome.php';
      } else {
        errorDiv.textContent = data.error;
      }
    })
    .catch(err => {
      errorDiv.textContent = "An error occurred.";
      console.error(err);
    });
  });
  