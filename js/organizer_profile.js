document.addEventListener("DOMContentLoaded", function() {
    // Mock data fetched from the database
    const profileData = {
        name: 'John Doe',
        register_number: '123456',
        email: 'john.doe@example.com',
        password: '********'
    };

    // Populate the profile information
    document.getElementById('name').innerText = profileData.name;
    document.getElementById('register_number').innerText = profileData.register_number;
    document.getElementById('email').innerText = profileData.email;
    document.getElementById('password').innerText = profileData.password;
});

function resetPassword() {
    alert('Password reset link has been sent to your email.');
    // Implement the logic to send a password reset link to the organizer's email
}

function logout() {
    // Implement the logic to log out the user
    // For example, redirect to the login page after clearing the session
    alert('Logged out successfully');
    window.location.href = 'index.html';
}
