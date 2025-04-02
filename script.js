document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    
    fetch('login.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
    })
    .then(response => response.json())
    .then(data => {
      if(data.success) {
        // Redirect to the dashboard page if login is successful
        window.location.href = 'dashboard.php';
      } else {
        document.getElementById('error').textContent = data.error;
      }
    })
    .catch(error => {
      console.error('Error:', error);
      document.getElementById('error').textContent = 'An error occurred.';
    });
  });
  