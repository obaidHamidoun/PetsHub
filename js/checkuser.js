// Check if the user is signed in
function checkUser() {
    const userType = getCookie('user_type');
    const currentPage = window.location.pathname;

    if (!userType) {
        // User is not signed in
        if (currentPage !== '/PetsHub/html/index.html' && currentPage !== '/PetsHub/html/login.html' && currentPage !== '/PetsHub/html/signUp.html') {
            window.location.href = '/PetsHub/html/index.html';
        }
    } else if (userType === 'admin') {
        // User is admin
        if (!currentPage.startsWith('/PetsHub/admin/')) {
            window.location.href = '/PetsHub/admin/index.php';
        }
    } else if (userType === 'client') {
        // User is client
        if (currentPage !== '/PetsHub/html/home.html'  && currentPage !== '/PetsHub/html/shop.html' && currentPage !== '/PetsHub/html/productBuyPage.php') {
            window.location.href = '/PetsHub/html/home.html';
        }
    }
}

// Function to get cookie value
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}

checkUser();
