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

// function resetPassword() {
//    // alert('Password reset link has been sent to your email.');
//    document.getElementById('resetPasswordBtn').addEventListener('click', function () {
//     window.location.href = 'reset_orgpassword.php';
// });
// }

function logout() {
    // Implement the logic to log out the user
    // For example, redirect to the login page after clearing the session
    alert('Logged out successfully');
    window.location.href = 'index.html';
}
